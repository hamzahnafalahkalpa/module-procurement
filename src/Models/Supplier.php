<?php

namespace Zahzah\ModuleProcurement\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Zahzah\LaravelHasProps\Concerns\HasProps;
use Zahzah\LaravelSupport\Models\BaseModel;
use Zahzah\ModuleProcurement\Resources\Supplier\ShowSupplier;
use Zahzah\ModuleProcurement\Resources\Supplier\ViewSupplier;

class Supplier extends BaseModel
{
    use HasProps, SoftDeletes;

    protected $list = [
        'id', 'name', 'phone', 'description', 'address', 'props'
    ];

    protected $casts = [
        'name' => 'string',
    ];

    public function toViewApi(){
        return new ViewSupplier($this);
    }

    public function toShowApi(){
        return new ShowSupplier($this);
    }

    public function procurement(){
        return $this->hasOneModel('Procurement');
    }

    public function procurements(){
        return $this->hasManyModel('Procurement');
    }
}
