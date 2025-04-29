<?php

namespace Hanafalah\ModuleProcurement\Models;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Concerns\Support\HasActivity;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModuleProcurement\Concerns\Procurement\HasProcurement;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\ModuleProcurement\Resources\PurchaseRequest\{
    ViewPurchaseRequest,
    ShowPurchaseRequest
};
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class PurchaseRequest extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes, HasProcurement, HasActivity;
    
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    public $list = [
        'id', 'name', 'approver_type', 'approver_id', 'purchasing_id',
        'estimate_used_at', 'props'
    ];

    protected $casts = [
        'name' => 'string',
        'approver_name' => 'string'
    ];

    public function getPropsQuery(): array
    {
        return [
            'approver_name' => 'props->prop_approver->name'
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
        return ['procurement.cardStocks'];
    }

    public function getViewResource(){
        return ViewPurchaseRequest::class;
    }

    public function getShowResource(){
        return ShowPurchaseRequest::class;
    }

    public function approver(){return $this->belongsToModel('approver');}
    public function purchasing(){return $this->belongsToModel('purchasing');}
}
