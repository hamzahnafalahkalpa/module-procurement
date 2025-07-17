<?php

namespace Hanafalah\ModuleProcurement\Models;

use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModuleProcurement\Resources\PurchasingHasRequest\{
    ShowPurchasingHasRequest,
    ViewPurchasingHasRequest
};
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class PurchasingHasRequest extends BaseModel
{
    use HasUlids;
    
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    public $list = [
        'id', 'purchasing_id', 'purchase_request_id'
    ];

    protected $casts = [
        'purchase_request_name' => 'string',
        'purchasing_name' => 'string'
    ];
    
    public function getPropsQuery(): array{
        return [
            'purchase_request_name' => 'props->prop_purchase_request->name',
            'purchasing_name'       => 'props->prop_purchasing->name'
        ];
    }

    public function viewUsingRelation(): array{
        return [];
    }

    public function showUsingRelation(): array{
        return [];
    }

    public function getViewResource(){
        return ViewPurchasingHasRequest::class;
    }

    public function getShowResource(){
        return ShowPurchasingHasRequest::class;
    }

    public function purchasing(){return $this->belongsToModel('Purchasing');}
    public function purchaseRequest(){return $this->belongsToModel('PurchaseRequest');}
}
