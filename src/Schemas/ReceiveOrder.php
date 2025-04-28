<?php

namespace Hanafalah\ModuleProcurement\Schemas;

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
        $purchase_request = $this->PurchaseRequestModel()->updateOrCreate([
            'id'   => $receive_order_dto->id ?? null
        ], [
            'name' => $receive_order_dto->name,
        ]);
        $this->initializeProcurementDTO($purchase_request,$receive_order_dto);
        $this->fillingProps($purchase_request,$receive_order_dto->props);
        $purchase_request->save();
        return static::$receive_order_model = $purchase_request;
    }
}