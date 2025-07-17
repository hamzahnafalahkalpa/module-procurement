<?php

namespace Hanafalah\ModuleProcurement\Models;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Concerns\Support\HasActivity;
use Hanafalah\LaravelSupport\Concerns\Support\HasFileUpload;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModuleProcurement\Concerns\Procurement\HasProcurement;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\ModuleProcurement\Resources\ReceiveOrder\{
    ViewReceiveOrder,
    ShowReceiveOrder
};
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class ReceiveOrder extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes, HasProcurement, HasActivity,
        HasFileUpload;
    
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    public $list = [
        'id', 'name', 'received_at', 'purchasing_id' , 'purchase_order_id', 'props'
    ];

    protected $casts = [
        'name' => 'string',
        'received_at' => 'immutable_date',
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
            $query->receive_order_code ??= static::hasEncoding('RECEIVE_ORDER');
        });
    }

    protected function getFileNameAttribute(): string|callable{
        return 'received_file';
    }

    public function viewUsingRelation(): array{
        return ['procurement'];
    }

    public function showUsingRelation(): array{
        return ['procurement.cardStocks' => function($query){
            $query->with(['item','stockMovement' => fn($query) => $query->withoutGlobalScope('parent_only')]);
        }, 'purchaseOrder' => function($query){
            $query->with([
                'supplier','procurement.cardStocks' => function($query){
                    $query->with(['item','stockMovement' => fn($query) => $query->withoutGlobalScope('parent_only')]);
                }
            ]);
        }];
    }

    public function getViewResource(){
        return ViewReceiveOrder::class;
    }

    public function getShowResource(){
        return ShowReceiveOrder::class;
    }

    public function purchasing(){return $this->belongsToModel('Purchasing');}
    public function purchaseOrder(){return $this->belongsToModel('PurchaseOrder');}
}
