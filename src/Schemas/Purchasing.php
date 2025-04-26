<?php

namespace Hanafalah\ModuleProcurement\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleProcurement\{
    Supports\BaseModuleProcurement
};
use Hanafalah\ModuleProcurement\Contracts\Schemas\Purchasing as ContractsPurchasing;
use Hanafalah\ModuleProcurement\Contracts\Data\PurchasingData;

class Purchasing extends BaseModuleProcurement implements ContractsPurchasing
{
    protected string $__entity = 'Purchasing';
    public static $purchasing_summary_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'purchasing_summary',
            'tags'     => ['purchasing_summary', 'purchasing_summary-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStorePurchasing(PurchasingData $purchasing_summary_dto): Model{
        $purchasing_summary = $this->PurchasingModel()->updateOrCreate([
                        'id' => $purchasing_summary_dto->id ?? null
                    ], [
                        'name' => $purchasing_summary_dto->name
                    ]);
        $this->fillingProps($purchasing_summary,$purchasing_summary_dto->props);
        $purchasing_summary->save();
        return static::$purchasing_summary_model = $purchasing_summary;
    }

    public function storePurchasing(?PurchasingData $purchasing_summary_dto = null): array{
        return $this->transaction(function() use ($purchasing_summary_dto){
            return $this->showPurchasing($this->prepareStorePurchasing($purchasing_summary_dto ?? $this->requestDTO(PurchasingData::class)));
        });
    }

    public function purchasing(mixed $conditionals = null): Builder{
        $this->booting();
        return $this->PurchasingModel()->withParameters()
                    ->conditionals($this->mergeCondition($conditionals ?? []))
                    ->orderBy('name', 'asc');
    }
}