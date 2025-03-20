<?php

namespace Zahzah\ModuleProcurement\Models;

use Zahzah\ModuleProcurement\Enums;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Zahzah\LaravelHasProps\Concerns\HasProps;
use Zahzah\LaravelSupport\Models\BaseModel;
use Zahzah\ModuleTransaction\Concerns\HasTransaction;

class Procurement extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes, HasTransaction;

    public $incrementing  = false;
    protected $primaryKey = 'id';
    protected $keyType    = 'string';

    protected $list = [
        'id', 'author_type', 'author_id', 'reported_at', 'props',
        'supplier_id', 'funding_id', 'total_cogs', 'total_tax',
        'warehouse_type','warehouse_id','status'
    ];

    protected $casts = [
        'reported_at' => 'date',
    ];

    protected static function booted(): void{
        parent::booted();
        static::creating(function($query){
            if (!isset($query->procurement_code)) {
                $query->procurement_code = static::hasEncoding('PROCUREMENT'); 
            }
            if (!isset($query->status)) $query->status = Enums\Procurement\Status::DRAFT->value;
        });
    }

    public function author(){
        return $this->morphTo();
    }

    public function supplier(){
        return $this->belongsToModel('Supplier');
    }

    public function funding(){
        return $this->belongsToModel('Funding');
    }

    public function cardStock(){
        $transaction_model = $this->TransactionModel();
        return $this->hasOneThroughModel(
            'CardStock', 
            'Transaction',
            $transaction_model->getTableName().'.reference_id',
            $transaction_model->getForeignKey(),
            $this->getKeyName(),
            $transaction_model->getKeyName()
        )->where($transaction_model->getTableName().'.reference_type',$this->getMorphClass());
    }

    public function cardStocks(){
        $transaction_model = $this->TransactionModel();
        return $this->hasManyThroughModel(
            'CardStock', 
            'Transaction',
            $transaction_model->getTableName().'.reference_id',
            $transaction_model->getForeignKey(),
            $this->getKeyName(),
            $transaction_model->getKeyName()
        )->where($transaction_model->getTableName().'.reference_type',$this->getMorphClass());
    }

    public function warehouse(){
        return $this->morphTo();
    }
}
