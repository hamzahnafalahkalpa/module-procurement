<?php

namespace Hanafalah\ModuleProcurement\Models;

use Hanafalah\ModuleProcurement\Resources\WorkOrder\{
    ViewWorkOrder,
    ShowWorkOrder
};

class WorkOrder extends Purchasing
{
    public $list = [
        'id', 'name', 'total_cogs', 'total_tax',
        'supplier_id', 'funding_id',
        'props'
    ];

    protected $casts = [
        'funding_name'   => 'string',
        'supplier_name'  => 'string'
    ];

    protected static function booted(): void{
        parent::booted();
        static::creating(function ($query) {
            $query->purchase_order_code ??= static::hasEncoding('PURCHASE_ORDER');
        });
    }

    public function viewUsingRelation(): array{
        return ['procurement','receiveOrder.procurement'];
    }

    public function showUsingRelation(): array{
        return ['procurement.cardStocks.stockMovement','receiveOrder.procurement'];
    }

    public function getViewResource(){
        return ViewWorkOrder::class;
    }

    public function getShowResource(){
        return ShowWorkOrder::class;
    }

    
    public function supplier(){return $this->belongsToModel('Supplier');}
    public function funding(){return $this->belongsToModel('Funding');}
    public function purchasing(){return $this->belongsToModel('Purchasing');}
    public function receiveOrder(){return $this->hasOneModel('ReceiveOrder');}
    public function receiveOrders(){return $this->hasManyModel('ReceiveOrder');}
}
