<?php

namespace Hanafalah\ModuleProcurement\Schemas;

use Hanafalah\ModuleProcurement\{
    Contracts\Schemas\Procurement as ContractsProcurement
};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleProcurement\Enums\Procurement\Status;

class Procurement extends PackageManagement implements ContractsProcurement
{
    protected array $__guard   = ['id'];
    protected array $__add     = [
        'id',
        'funding_id',
        'supplier_id',
        'total_cogs',
        'reported_at',
        'author_id',
        'author_type'
    ];
    protected string $__entity = 'Procurement';
    public static $procurement_model;
    public static $procurement_item_model;

    public function showUsingRelation(): array
    {
        return [
            'transaction',
            'warehouse',
            'author',
            'funding',
            'supplier',
            'cardStocks' => function ($query) {
                $query->with([
                    'item',
                    'stockMovements' => function ($query) {
                        $query->with([
                            'goodsReceiptUnit',
                            'reference',
                            'itemStock.funding',
                            'childs.batchMovements.batch',
                            'batchMovements.batch'
                        ]);
                    }
                ]);
            }
        ];
    }

    public function getProcurement(): mixed
    {
        return static::$procurement_model;
    }

    public function prepareShowProcurement(?Model $model = null, ?array $attributes = null): ?Model
    {
        $attributes ??= request()->all();
        $model ??= $this->getProcurement();

        if (!isset($model)) {
            $id = $attributes['id'] ?? null;
            if (!isset($id)) throw new \Exception('No id provided', 422);

            $model = $this->procurement()->with($this->showUsingRelation())->find($id);
        } else {
            $model->load($this->showUsingRelation());
        }

        return static::$procurement_model = $model;
    }

    public function showProcurement(?Model $model = null): array
    {
        return $this->transforming($this->__resources['show'], function () use ($model) {
            return $this->prepareShowProcurement($model);
        });
    }

    public function prepareStoreProcurement(mixed $attributes = null): Model
    {
        $attributes ??= request()->all();

        if (!isset($attributes['warehouse_id'])) throw new \Exception('No warehouse id provided', 422);
        if (!isset($attributes['morphs'])) throw new \Exception('No morphs provided', 422);

        if (isset($attributes['author_id'])) {
            if (!isset($attributes['author_type'])) $attributes['author_type'] = app(config('module-procurement.author'))->getMorphClass();
        }
        if (!isset($attributes['funding_id'])) {
            $funding = $this->FundingModel()->where('name', 'Mandiri')->first();
            if (isset($funding)) {
                $attributes['funding_id'] = $funding->getKey();
            }
        }
        $procurement = $this->{$this->__entity . 'Model'}()->updateOrCreate([
            'id' => $attributes['id'] ?? null
        ], [
            'funding_id'     => $attributes['funding_id'] ?? $funding->id ?? null,
            'supplier_id'    => $attributes['supplier_id'] ?? null,
            'author_id'      => $attributes['author_id'] ?? null,
            'author_type'    => $attributes['author_type'] ?? null,
            'warehouse_id'   => $attributes['warehouse_id'],
            'warehouse_type' => app(config('module-procurement.warehouse'))->getMorphClass(),
        ]);

        $this->forgetTags('procurement');
        static::$procurement_model = &$procurement;
        $transaction    = $procurement->transaction;
        $procurement->total_cogs = 0;
        if (isset($attributes['card_stocks']) && count($attributes['card_stocks']) > 0) {
            $transaction_id = $transaction->getKey();
            $keep           = [];
            foreach ($attributes['card_stocks'] as $card_stock) {
                $card_stock['transaction_id'] = $transaction_id;
                $card_stock['direction']      = $this->StockMovementModel()::IN;
                $card_stock['funding_id']     = $procurement->funding_id;
                $card_stock['warehouse_id']   = $attributes['warehouse_id'];
                $card_stock_model             = $this->prepareStoreProcurementItems($card_stock);
                $keep[]                       = $card_stock_model->getKey();
                $procurement->total_cogs     += $card_stock_model->total_cogs;
            }
            $procurement->save();
            $this->CardStockModel()->where('transaction_id', $transaction->getKey())
                ->whereNotIn('id', $keep)->delete();
        } else {
            $this->CardStockModel()->where('transaction_id', $transaction->getKey())->delete();
        }
        return static::$procurement_model = $procurement;
    }

    public function prepareStoreProcurementItems(mixed $attributes = null): Model
    {
        $attributes ??= request()->all();
        if (!isset($attributes['transaction_id'])) {
            if (!isset(static::$procurement_model)) {
                $procurement = static::$procurement_model;
            } else {
                $id = $attributes['procurement_id'] ?? null;
                if (!isset($id)) throw new \Exception('No procurement id provided', 422);
                $procurement = $this->ProcurementModel()->find($id);
            }
            $attributes['transaction_id'] = $procurement->transaction->getKey();
        }
        $attributes['is_procurement'] = true;
        $procurement_item = $this->schemaContract('card_stock')->prepareStoreCardStock($attributes);

        $procurement_item->tax = $attributes['tax'] ?? 0;
        if (isset($procurement_item->total_cogs)) {
            $procurement_item->total_tax = $procurement_item->total_cogs * ($procurement_item->tax / 100);
        }
        $procurement_item->save();
        return static::$procurement_item_model = $procurement_item;
    }

    public function storeProcurement(): array
    {
        return $this->transaction(function () {
            return $this->showProcurement($this->prepareStoreProcurement());
        });
    }

    public function prepareProcurementPaginate(mixed $cache_reference_type, ?array $morphs = null, int $perPage = 50, array $columns = ['*'], string $pageName = 'page', ?int $page = null, ?int $total = null): LengthAwarePaginator
    {
        $morphs ??= $cache_reference_type;
        $paginate_options = compact('perPage', 'columns', 'pageName', 'page', 'total');
        return static::$procurement_model = $this->procurement($morphs)->paginate(
            ...$this->arrayValues($paginate_options)
        );
    }

    public function viewProcurementPaginate(mixed $reference_type, ?array $morphs = null, int $perPage = 50, array $columns = ['*'], string $pageName = 'page', ?int $page = null, ?int $total = null): array
    {
        $paginate_options = compact('perPage', 'columns', 'pageName', 'page', 'total');
        return $this->transforming($this->__resources['view'], function () use ($reference_type, $morphs, $paginate_options) {
            return $this->prepareProcurementPaginate($reference_type, $morphs, ...$this->arrayValues($paginate_options));
        }, ['rows_per_page' => [50]]);
    }

    public function prepareMainReportProcurement(Model $procurement): Model
    {
        if (isset($procurement->reported_at)) throw new \Exception('Procurement already reported', 422);
        $procurement->reported_at = now();
        $procurement->status = Status::REPORTED->value;
        $procurement->save();
        $procurement->reporting();
        $procurement->load('cardStocks');
        $card_stocks = $procurement->cardStocks;
        //UPDATING STOCK
        if (isset($card_stocks) && count($card_stocks) > 0) {
            foreach ($card_stocks as $card_stock) {
                $card_stock->reported_at = now();
                $card_stock->save();
            }
        }

        return $procurement;
    }

    public function prepareReportProcurement(?array $attributes = null): Model
    {
        $attributes ??= request()->all();
        if (!isset($attributes['id'])) throw new \Exception('No id provided', 422);

        $procurement = $this->{$this->__entity . 'Model'}()->find($attributes['id']);
        return static::$procurement_model = $this->prepareMainReportProcurement($procurement);
    }

    public function reportProcurement(): array
    {
        return $this->transaction(function () {
            return $this->showProcurement($this->prepareReportProcurement());
        });
    }

    public function prepareDeleteProcurement(?array $attributes = null): bool
    {
        $attributes ??= request()->all();
        if (!isset($attributes['id'])) throw new \Exception('No id provided', 422);

        $model = $this->procurement()->findOrFail($attributes['id']);
        return $model->delete();
    }

    public function deleteProcurement(): bool
    {
        return $this->transaction(function () {
            return $this->prepareDeleteProcurement();
        });
    }

    public function procurement(mixed $morphs = null, mixed $conditionals = null): Builder
    {
        $this->booting();
        return $this->ProcurementModel()->with(['transaction', 'author'])
            ->when(isset($morphs), function ($q) use ($morphs) {
                $morphs = $this->mustArray($morphs);
                $q->whereHas('transaction', function ($q) use ($morphs) {
                    $q->whereIn('reference_type', $morphs);
                });
            })->withParameters()->conditionals($conditionals);
    }
}
