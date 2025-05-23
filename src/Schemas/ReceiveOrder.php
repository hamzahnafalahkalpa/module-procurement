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
        $receive_order = $this->ReceiveOrderModel()->updateOrCreate([
            'id'   => $receive_order_dto->id ?? null
        ], [
            'name'               => $receive_order_dto->name,
            "purchasing_id"      => $receive_order_dto->purchasing_id,
            "purchase_order_id"  => $receive_order_dto->purchase_order_id,
            "receipt_code"       => $receive_order_dto->receipt_code,
            "received_at"        => $receive_order_dto->received_at,
            "sender_name"        => $receive_order_dto->sender_name
        ]);
        $this->initializeProcurementDTO($receive_order,$receive_order_dto);
        $receive_order_dto->props['received_file'] = $receive_order->setupFile($receive_order_dto->received_file);
        $this->fillingProps($receive_order,$receive_order_dto->props);
        $receive_order->save();
        return static::$receive_order_model = $receive_order;
    }
}