<?php

namespace Hanafalah\ModuleProcurement\Models;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Concerns\Support\HasActivity;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModuleProcurement\Enums;
use Hanafalah\ModuleProcurement\Resources\Procurement\{ShowProcurement, ViewProcurement};
use Hanafalah\ModuleTransaction\Concerns\HasJournalEntry;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Procurement extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes, HasActivity,
        HasJournalEntry;

    public $incrementing  = false;
    protected $primaryKey = 'id';
    protected $keyType    = 'string';
    
    protected $list = [
        'id', 'name', 'reference_type', 'reference_id', 
        'author_type', 'author_id', 'purchase_label_id',
        'warehouse_type', 'warehouse_id', 
        'sender_type', 'sender_id', 'total_cogs',
        'reported_at', 'approved_at', 'status', 'props'
    ];

    protected $casts = [
        'reported_at'    => 'date',
        'approved_at' => 'date',
        'is_approved' => 'boolean',
        'is_reported' => 'boolean',
        'author_name'    => 'string',
        'warehouse_name' => 'string',
        'purchase_label_id' => 'string',
    ];

    public function getPropsQuery(): array
    {
        return [
            'author_name'    => 'props->prop_author->name',
            'warehouse_name' => 'props->prop_warehouse->name',
            'is_reported' => 'props->is_reported',
            'is_approved' => 'props->is_approved'
        ];
    }

    protected static function booted(): void{
        parent::booted();
        static::creating(function ($query) {
            if (!isset($query->procurement_code)) {
                $query->procurement_code = static::hasEncoding('PROCUREMENT');
            }
            if (!isset($query->status)) $query->status = Enums\Procurement\Status::DRAFT->value;
        });
    }

    public function viewUsingRelation(): array{
        return ['transaction'];
    }

    public function showUsingRelation(): array{
        return [
            'transaction', 'cardStocks' => function ($query) {
                $query->with([
                    'item', 'stockMovements' => function ($query) {
                        $query->with([
                            'goodsReceiptUnit', 'reference',
                            'itemStock.funding',
                            'childs.batchMovements.batch',
                            'batchMovements.batch'
                        ]);
                    }
                ]);
            }
        ];
    }

    public function getViewResource(){return ViewProcurement::class;}
    public function getShowResource(){return ShowProcurement::class;}

    public function author(){return $this->morphTo();}
    public function reference(){return $this->morphTo();}
    public function warehouse(){return $this->morphTo();}
    public function cardStock(){return $this->morphOneModel('CardStock','reference');}
    public function cardStocks(){return $this->morphManyModel('CardStock','reference');}
    public function purchaseLabel(){return $this->belongsToModel('PurchaseLabel');}
}
