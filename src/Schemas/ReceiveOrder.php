<?php

namespace Hanafalah\ModuleProcurement\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleProcurement\{
    Supports\BaseModuleProcurement
};
use Hanafalah\ModuleProcurement\Contracts\Schemas\ReceiveOrder as ContractsReceiveOrder;
use Hanafalah\ModuleProcurement\Contracts\Data\ReceiveOrderData;

class ReceiveOrder extends BaseModuleProcurement implements ContractsReceiveOrder
{
    protected string $__entity = 'ReceiveOrder';
    public static $receive_order_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'receive_order',
            'tags'     => ['receive_order', 'receive_order-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreReceiveOrder(ReceiveOrderData $receive_order_dto): Model{
        $receive_order = $this->ReceiveOrderModel()->updateOrCreate([
                        'id' => $receive_order_dto->id ?? null
                    ], [
                        'name' => $receive_order_dto->name
                    ]);
        $this->fillingProps($receive_order,$receive_order_dto->props);
        $receive_order->save();
        return static::$receive_order_model = $receive_order;
    }

    public function storeReceiveOrder(?ReceiveOrderData $receive_order_dto = null): array{
        return $this->transaction(function() use ($receive_order_dto){
            return $this->showReceiveOrder($this->prepareStoreReceiveOrder($receive_order_dto ?? $this->requestDTO(ReceiveOrderData::class)));
        });
    }

    public function receiveOrder(mixed $conditionals = null): Builder{
        $this->booting();
        return $this->ReceiveOrderModel()->withParameters()
                    ->conditionals($this->mergeCondition($conditionals ?? []))
                    ->orderBy('name', 'asc');
    }
}