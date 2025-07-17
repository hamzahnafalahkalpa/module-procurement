<?php

namespace Hanafalah\ModuleProcurement\Models;

use Hanafalah\ModuleProcurement\Resources\WorkOrder\{
    ViewWorkOrder,
    ShowWorkOrder
};

class WorkOrder extends PurchaseOrder
{
    protected $table = 'purchase_orders';

    public function showUsingRelation(): array{
        return [
            'procurement', 'purchaseOrders' => function($query){
                $query->with(['procurement.cardStocks.stockMovement']);
            }
        ];
    }

    public function getViewResource(){
        return ViewWorkOrder::class;
    }

    public function getShowResource(){
        return ShowWorkOrder::class;
    }

    public function purchaseOrders(){return $this->hasManyModel('PurchaseOrder','parent_id');}
}
