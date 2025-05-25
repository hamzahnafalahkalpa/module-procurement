<?php

namespace Hanafalah\ModuleProcurement\Schemas;

use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleProcurement\Contracts\Schemas\WorkOrder as ContractsWorkOrder;
use Hanafalah\ModuleProcurement\Contracts\Data\WorkOrderData;

class WorkOrder extends PurchaseOrder implements ContractsWorkOrder
{
    protected string $__entity = 'WorkOrder';
    public static $work_order_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'work_order',
            'tags'     => ['work_order', 'work_order-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreWorkOrder(WorkOrderData $work_order_dto): Model{
        $work_order = $this->prepareStorePurchaseOrder($work_order_dto);
        $this->initializeProcurementDTO($work_order,$work_order_dto);
        $work_order->load('procurement');
        $procurement = &$work_order->procurement;
        $work_order_dto->id ??= $work_order->getKey();
        
        if (isset($work_order_dto->purchase_orders) && count($work_order_dto->purchase_orders)){
            $procurment_dto       = &$work_order_dto->procurement;
            $purchasing_total_tax = &$procurment_dto->props->total_tax;
            $contractor           = $this->{$work_order_dto->supplier_type.'Model'}()->find($work_order_dto->supplier_id);
            foreach ($work_order_dto->purchase_orders as $order_dto){
                $order_dto->parent_id                     = $work_order->getKey();
                $order_dto->procurement->props->tax       = clone $work_order_dto->procurement->props->tax;
                $order_dto->procurement->props->total_tax = clone $work_order_dto->procurement->props->total_tax;
                $order_dto->supplier_type     = $contractor->getMorphClass();
                $order_dto->supplier_id       = $contractor->getKey();
                $order_dto->props->props['prop_sub_contractor'] = [
                    'id'   => $contractor->getKey(),
                    'flag' => 'SubContractor',
                    'name' => $contractor->name
                ];
                $po = $this->prepareStorePurchaseOrder($order_dto);
                $po_procurement = $po->procurement;
                $purchasing_total_tax->total += $po_procurement->total_tax['total'];
                $purchasing_total_tax->pph   += $po_procurement->total_tax['pph'];
                $purchasing_total_tax->ppn   += $po_procurement->total_tax['ppn'];
                $procurement->total_cogs     += $po_procurement->total_tax['total'];
            }
        }

        $this->fillingProps($work_order,$work_order_dto->props);
        $this->fillingProps($work_order->procurement,$work_order_dto->procurement->props);
        $work_order->save();
        return static::$work_order_model = $work_order;
    }
}