<?php

namespace Hanafalah\ModuleProcurement\Models;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Concerns\Support\HasActivity;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModuleProcurement\Concerns\Procurement\HasProcurement;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\ModuleProcurement\Resources\PurchaseOrder\{
    ViewPurchaseOrder,
    ShowPurchaseOrder
};
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class PurchaseOrder extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes, HasProcurement, HasActivity;
    
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    public $list = [
        'id', 'total_cogs', 'total_tax',
        'supplier_id', 'funding_id', 'purchasing_id', 
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
        return ViewPurchaseOrder::class;
    }

    public function getShowResource(){
        return ShowPurchaseOrder::class;
    }

    
    public function supplier(){return $this->belongsToModel('Supplier');}
    public function funding(){return $this->belongsToModel('Funding');}
    public function purchasing(){return $this->belongsToModel('Purchasing');}
    public function receiveOrder(){return $this->hasOneModel('ReceiveOrder');}
    public function receiveOrders(){return $this->hasManyModel('ReceiveOrder');}
}
