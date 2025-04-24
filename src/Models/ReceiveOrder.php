<?php

namespace Hanafalah\ModuleProcurement\Models;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Concerns\Support\HasActivity;
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
    use HasUlids, HasProps, SoftDeletes, HasProcurement, HasActivity;
    
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    public $list = [
        'id', 'name', 'props'
    ];

    protected $casts = [
        'name' => 'string'
    ];

    protected static function booted(): void{
        parent::booted();
        static::creating(function ($query) {
            $query->receive_order_code ??= static::hasEncoding('RECEIVE_ORDER');
        });
    }

    public function viewUsingRelation(): array{
        return ['procurement'];
    }

    public function showUsingRelation(): array{
        return ['procurement'];
    }

    public function getViewResource(){
        return ViewReceiveOrder::class;
    }

    public function getShowResource(){
        return ShowReceiveOrder::class;
    }
}
