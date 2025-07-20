<?php

namespace Hanafalah\ModuleProcurement\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleProcurement\{
    Supports\BaseModuleProcurement
};
use Hanafalah\ModuleProcurement\Contracts\Schemas\PurchaseOrder as ContractsPurchaseOrder;
use Hanafalah\ModuleProcurement\Contracts\Data\PurchaseOrderData;

class PurchaseOrder extends BaseModuleProcurement implements ContractsPurchaseOrder
{
    protected string $__entity = 'PurchaseOrder';
    public $purchase_order_model;
    protected mixed $__order_by_created_at = 'desc'; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'purchase_order',
            'tags'     => ['purchase_order', 'purchase_order-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStorePurchaseOrder(PurchaseOrderData $purchase_order_dto): Model{
        $purchase_order = $this->usingEntity()->updateOrCreate([
                        'id' => $purchase_order_dto->id ?? null
                    ], [
                        'parent_id'     => $purchase_order_dto->parent_id ?? null,
                        'funding_id'    => $purchase_order_dto->funding_id,
                        'supplier_type' => $purchase_order_dto->supplier_type,
                        'supplier_id'   => $purchase_order_dto->supplier_id,
                        'purchasing_id' => $purchase_order_dto->purchasing_id,
                        'name'          => $purchase_order_dto->name,
                    ]);
        $this->initializeProcurementDTO($purchase_order,$purchase_order_dto);
        $this->fillingProps($purchase_order,$purchase_order_dto->props);
        $purchase_order->save();
        return $this->purchase_order_model = $purchase_order;
    }
}