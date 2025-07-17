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

use Illuminate\Support\Str;

class PurchaseOrder extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes, 
        HasProcurement, HasActivity;
    
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    public $list = [
        'id', 'parent_id', 'name', 'supplier_type', 
        'supplier_id', 'funding_id', 'flag', 
        'purchasing_id', 'received_address', 
        'phone', 'props'
    ];

    protected $casts = [
        'name'           => 'string',
        'funding_name'   => 'string',
        'supplier_id'    => 'string',
        'supplier_name'  => 'string',
        'purchasing_id'  => 'string',
        'is_approved' => 'boolean',
        'is_reported' => 'boolean',
    ];

    public function getPropsQuery(): array{
        return [
            'is_reported' => 'props->prop_procurement->is_reported',
            'is_approved' => 'props->prop_procurement->is_approved'
        ];
    }

    protected static function booted(): void{
        parent::booted();
        static::creating(function ($query) {
            $morph = $query->getMorphClass();
            $query->{Str::snake($morph).'_code'} = static::hasEncoding(Str::upper(Str::snake($morph)));
            $query->flag ??= $morph;
        });
    }

    public function viewUsingRelation(): array{
        return ['procurement', 'supplier'];
    }

    public function showUsingRelation(): array{
        return ['procurement.cardStocks' => function($query){
            $query->with(['item','stockMovement']);
        },'receiveOrder.procurement', 'purchasing'];
    }

    public function getViewResource(){
        return ViewPurchaseOrder::class;
    }

    public function getShowResource(){
        return ShowPurchaseOrder::class;
    }

    public function supplier(){return $this->morphTo('Supplier');}
    public function funding(){return $this->belongsToModel('Funding');}
    public function purchasing(){return $this->belongsToModel('Purchasing');}
    public function receiveOrder(){return $this->hasOneModel('ReceiveOrder');}
    public function receiveOrders(){return $this->hasManyModel('ReceiveOrder');}
}
