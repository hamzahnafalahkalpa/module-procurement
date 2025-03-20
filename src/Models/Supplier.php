<?php

namespace Hanafalah\ModuleProcurement\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Hanafalah\LaravelHasProps\Concerns\HasProps;
use Hanafalah\LaravelSupport\Models\BaseModel;
use Hanafalah\ModuleProcurement\Resources\Supplier\ShowSupplier;
use Hanafalah\ModuleProcurement\Resources\Supplier\ViewSupplier;

class Supplier extends BaseModel
{
    use HasProps, SoftDeletes;

    protected $list = [
        'id',
        'name',
        'phone',
        'description',
        'address',
        'props'
    ];

    protected $casts = [
        'name' => 'string',
    ];

    public function toViewApi()
    {
        return new ViewSupplier($this);
    }

    public function toShowApi()
    {
        return new ShowSupplier($this);
    }

    public function procurement()
    {
        return $this->hasOneModel('Procurement');
    }

    public function procurements()
    {
        return $this->hasManyModel('Procurement');
    }
}
