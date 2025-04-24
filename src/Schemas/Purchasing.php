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
    public static $purchasing_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'purchasing',
            'tags'     => ['purchasing', 'purchasing-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStorePurchasing(PurchasingData $purchasing_dto): Model{
        $purchasing = $this->PurchasingModel()->updateOrCreate([
                        'id' => $purchasing_dto->id ?? null
                    ], [
                        'name' => $purchasing_dto->name
                    ]);
        $this->fillingProps($purchasing,$purchasing_dto->props);
        $purchasing->save();
        return static::$purchasing_model = $purchasing;
    }

    public function storePurchasing(?PurchasingData $purchasing_dto = null): array{
        return $this->transaction(function() use ($purchasing_dto){
            return $this->showPurchasing($this->prepareStorePurchasing($purchasing_dto ?? $this->requestDTO(PurchasingData::class)));
        });
    }

    public function purchasing(mixed $conditionals = null): Builder{
        $this->booting();
        return $this->PurchasingModel()->withParameters()
                    ->conditionals($this->mergeCondition($conditionals ?? []))
                    ->orderBy('name', 'asc');
    }

    public function purchasingHasRequests(){return $this->belongsToManyModel();}
}