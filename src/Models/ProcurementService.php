<?php

namespace Hanafalah\ModuleProcurement\Models;

use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\ModuleProcurement\Resources\ProcurementService\{
    ViewProcurementService,
    ShowProcurementService
};
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class ProcurementService extends BaseModel
{
    use HasUlids, HasProps, SoftDeletes;
    
    public $incrementing  = false;
    protected $keyType    = 'string';
    protected $primaryKey = 'id';
    public $list = [
        'id', 'procurement_id', 'service_id', 'props',
    ];

    protected $casts = [
        'service_name' => 'string'
    ];

    public function getPropsQuery(): array
    {
        return [
            'service_name' => 'props->prop_service->name'
        ];
    }

    public function viewUsingRelation(): array{
        return [];
    }

    public function showUsingRelation(): array{
        return [];
    }

    public function getViewResource(){
        return ViewProcurementService::class;
    }

    public function getShowResource(){
        return ShowProcurementService::class;
    }

    public function service(){return $this->belongsToModel('Service');}
    public function procurement(){return $this->belongsToModel('Procurement');}
    
}
