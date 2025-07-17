<?php

namespace Hanafalah\ModuleProcurement\Models;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Concerns\Support\HasActivity;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModuleProcurement\Concerns\Procurement\HasProcurement;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\ModuleProcurement\Resources\PurchaseRequest\{
    ViewPurchaseRequest, ShowPurchaseRequest
};
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class PurchaseRequest extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes, HasProcurement, HasActivity;
    
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    public $list = [
        'id', 'name', 'approver_type', 'approver_id',
        'purchasing_id', 'estimate_used_at', 'props'
    ];

    protected $casts = [
        'name' => 'string',
        'approver_name' => 'string',
        'purchase_label_id' => 'string',
        'is_approved' => 'boolean',
        'is_reported' => 'boolean',
    ];

    public function getPropsQuery(): array{
        return [
            'approver_name' => 'props->prop_approver->name',
            'purchase_label_id' => 'props->prop_procurement->purchase_label_id',
            'is_reported' => 'props->prop_procurement->is_reported',
            'is_approved' => 'props->prop_procurement->is_approved'
        ];
    }

    protected static function booted(): void{
        parent::booted();
        static::creating(function ($query) {
            $query->purchase_request_code ??= static::hasEncoding('PURCHASE_REQUEST');
        });
    }
    

    public function viewUsingRelation(): array{
        return ['procurement'];
    }

    public function showUsingRelation(): array{
        return ['procurement.cardStocks' => function($query){
            $query->with([
                'item', 'stockMovement'
            ]);
        }];
    }

    public function getViewResource(){
        return ViewPurchaseRequest::class;
    }

    public function getShowResource(){
        return ShowPurchaseRequest::class;
    }

    public function approver(){return $this->morphTo();}
    public function purchasing(){return $this->belongsToModel('Purchasing');}
}
