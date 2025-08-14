<?php

namespace Hanafalah\ModuleProcurement\Models;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModuleProcurement\Concerns\Procurement\HasProcurement;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\ModuleProcurement\Resources\Purchasing\{
    ViewPurchasing,
    ShowPurchasing
};
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Purchasing extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes, HasProcurement;
    
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    public $list = [
        'id',
        'name',
        'props',
    ];

    protected $casts = [
        'name' => 'string',
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
            $query->purchasing_code ??= static::hasEncoding('PURCHASING');
        });
        static::deleted(function ($query) {
            $query->purchaseOrders()->delete();
        });
    }

    public function viewUsingRelation(): array{
        return ['procurement'];
    }

    public function showUsingRelation(): array{
        return [
            'procurement',
            'purchaseOrders' => function($query){
                $query->with([
                    'procurement.cardStocks' => function($query){
                        $query->with(['item.reference', 'stockMovement']);
                    }
                ]);
            }
        ];
    }

    public function getViewResource(){
        return ViewPurchasing::class;
    }

    public function getShowResource(){
        return ShowPurchasing::class;
    }
    
    public function purchaseRequests(){return $this->hasManyModel('PurchaseRequest');}
    public function purchaseOrders(){return $this->hasManyModel('PurchaseOrder');}
}
