<?php

namespace Hanafalah\ModuleProcurement\Schemas;

use Hanafalah\ModuleProcurement\{
    Contracts\Schemas\Procurement as ContractsProcurement
};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleProcurement\Contracts\Data\ProcurementData;
use Hanafalah\ModuleProcurement\Enums\Procurement\Status;

class Procurement extends PackageManagement implements ContractsProcurement
{
    protected string $__entity = 'Procurement';
    public $procurement_model;
    public $procurement_item_model;
    protected mixed $__order_by_created_at = 'desc'; //asc, desc, false

    public function prepareStoreProcurement(ProcurementData $procurement_dto): Model{
        $procurement = $this->usingEntity()->updateOrCreate([
            'id' => $procurement_dto->id ?? null
        ], [
            'author_id'      => $procurement_dto->author_id ?? null,
            'author_type'    => $procurement_dto->author_type ?? null,
            'warehouse_id'   => $procurement_dto->warehouse_id,
            'warehouse_type' => $procurement_dto->warehouse_type,
            'purchase_label_id' => $procurement_dto->purchase_label_id,
            'name'           => $procurement_dto->name
        ]);

        $procurement_dto->total_cogs   ??= 0;
        $procurement->load("transaction");
        if (isset($procurement_dto->props->total_tax)){
            $proc_props = &$procurement_dto->props;
            $proc_props->total_tax->total ??= 0;
            $proc_props->total_tax->ppn   ??= 0;
        }
        $this->prepareStoreCardStock($procurement_dto, $procurement);
        $this->prepareStoreProcurementService($procurement_dto, $procurement);
        $this->prepareStoreProcurementList($procurement_dto, $procurement);

        $procurement->total_cogs = $procurement_dto->total_cogs + $procurement_dto->props->total_tax?->total ?? 0;
        $this->fillingProps($procurement,$procurement_dto->props);
        if (isset($procurement_dto->reported_at)) $procurement->reported_at = $procurement_dto->reported_at;
        if (isset($procurement_dto->approved_at)) $procurement->approved_at = $procurement_dto->approved_at;
        $procurement->save();
        return $this->procurement_model = $procurement;
    }

    protected function prepareStoreProcurementService(ProcurementData $procurement_dto, Model $procurement): void{
        $is_calculate_total_cogs = !isset($procurement_dto->total_cogs);
        if (isset($procurement_dto->procurement_services) && count($procurement_dto->procurement_services) > 0) {
            $keep           = [];
            foreach ($procurement_dto->procurement_services as $ps_dto) {
                $ps_dto->procurement_id = $procurement->getKey();
                $ps_dto->service_id = $procurement->getKey();
                $procurement_service_model = $this->schemaContract('procurement_service')->prepareStoreProcurementService($ps_dto);
                if ($is_calculate_total_cogs) $procurement_dto->total_cogs += $procurement_service_model->total_cogs;
                $keep[] = $procurement_service_model->getKey();
            }
            $this->ProcurementServiceModel()->where('procurement_id', $procurement->getKey())
                 ->whereNotIn('id', $keep)->delete();
        } else {
        }
    }

    protected function prepareStoreCardStock(ProcurementData &$procurement_dto, Model $procurement): void{
        $transaction = $procurement->transaction;
        // $is_calculate_total_cogs = !isset($procurement_dto->total_cogs);
        if (isset($procurement_dto->card_stocks) && count($procurement_dto->card_stocks) > 0) {
            $transaction_id = $transaction->getKey();
            $keep           = [];
            foreach ($procurement_dto->card_stocks as $card_stock_dto) {
                $card_stock_dto->transaction_id = $transaction_id;
                $card_stock_dto->reference_id   = $procurement->getKey();
                $card_stock_dto->reference_type = $procurement->getMorphClass();
                if (isset($card_stock_dto->stock_movement)){
                    $stock_movement_dto               = &$card_stock_dto->stock_movement;
                    $stock_movement_dto->funding_id ??= $procurement->funding_id ?? null;
                    if (isset($stock_movement_dto->item_stock)){
                        $item_stock_dto = &$stock_movement_dto->item_stock;
                        $item_stock_dto->procurement_id ??= $procurement->getKey();
                        $item_stock_dto->procurement_type ??= $procurement->getMorphClass();
                    }
                }
                
                $card_stock_dto->transaction_id ??= $transaction->getKey();
                $props = &$card_stock_dto->props->props;
                $props['is_procurement'] = true;
                $props['prop_reference'] = $procurement->toViewApi()->resolve();
                $card_stock_dto->props->props['tax'] = $procurement_dto->props->tax;
                $card_stock_model = $this->schemaContract('card_stock')->prepareStoreCardStock($card_stock_dto);
                $procurement_dto->total_cogs += $card_stock_model->total_cogs;
                if (isset($procurement_dto->props->total_tax)){
                    $procurement_dto->props->total_tax->ppn   += $card_stock_model->total_tax;
                    $procurement_dto->props->total_tax->total += $card_stock_model->total_tax;
                }
                $keep[] = $card_stock_model->getKey();
            }
            $this->CardStockModel()->where('transaction_id', $transaction->getKey())->whereNotIn('id', $keep)->delete();
        } else {
            $this->CardStockModel()->where('transaction_id', $transaction->getKey())->delete();
        }
    }

    public function prepareMainReportProcurement(Model $procurement): Model{
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

    public function prepareReportProcurement(?array $attributes = null): Model{
        $attributes ??= request()->all();
        if (!isset($attributes['id'])) throw new \Exception('No id provided', 422);

        $procurement = $this->{$this->__entity . 'Model'}()->find($attributes['id']);
        return $this->procurement_model = $this->prepareMainReportProcurement($procurement);
    }

    public function reportProcurement(): array{
        return $this->transaction(function () {
            return $this->showProcurement($this->prepareReportProcurement());
        });
    }

    public function procurement(mixed $morphs = null, mixed $conditionals = null): Builder{
        $this->booting();
        return $this->ProcurementModel()->when(isset($morphs), function ($q) use ($morphs) {
                $morphs = $this->mustArray($morphs);
                $q->whereHas('transaction', function ($q) use ($morphs) {
                    $q->whereIn('reference_type', $morphs);
                });
            })->withParameters()->conditionals($conditionals);
    }
}
