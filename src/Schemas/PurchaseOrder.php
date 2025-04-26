<?php

namespace Hanafalah\ModuleProcurement\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleProcurement\{
    Supports\BaseModuleProcurement
};
use Hanafalah\ModuleProcurement\Contracts\Schemas\PurchaseOrder as ContractsPurchaseOrder;
use Hanafalah\ModuleProcurement\Contracts\Data\PurchaseOrderData;

class PurchaseOrder extends BaseModuleProcurement implements ContractsPurchaseOrder
{
    protected string $__entity = 'PurchaseOrder';
    public static $purchase_order_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'purchase_order',
            'tags'     => ['purchase_order', 'purchase_order-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStorePurchaseOrder(PurchaseOrderData $purchase_order_dto): Model{
        $purchase_order = $this->PurchaseOrderModel()->updateOrCreate([
                        'id' => $purchase_order_dto->id ?? null
                    ], [
                        'name' => $purchase_order_dto->name
                    ]);
        $this->fillingProps($purchase_order,$purchase_order_dto->props);
        $purchase_order->save();
        return static::$purchase_order_model = $purchase_order;
    }

    public function storePurchaseOrder(?PurchaseOrderData $purchase_order_dto = null): array{
        return $this->transaction(function() use ($purchase_order_dto){
            return $this->showPurchaseOrder($this->prepareStorePurchaseOrder($purchase_order_dto ?? $this->requestDTO(PurchaseOrderData::class)));
        });
    }

    public function purchaseOrder(mixed $conditionals = null): Builder{
        $this->booting();
        return $this->PurchaseOrderModel()->withParameters()
                    ->conditionals($this->mergeCondition($conditionals ?? []))
                    ->orderBy('name', 'asc');
    }
}