<?php

namespace Hanafalah\ModuleProcurement\Models;

use Hanafalah\ModuleOrganization\Models\Organization;
use Hanafalah\ModuleProcurement\Resources\Supplier\ShowSupplier;
use Hanafalah\ModuleProcurement\Resources\Supplier\ViewSupplier;

class Supplier extends Organization
{
    protected $table = 'organizations';

    protected static function booted(): void{
        parent::booted();
        static::addGlobalScope('flag',function($query){
            $query->flagIn('Supplier');
        });
        static::creating(function ($query) {
            $query->flag = 'Supplier';
        });
    }

    public function getViewResource(){
        return ViewSupplier::class;
    }

    public function getShowResource(){
        return ShowSupplier::class;
    }

    public function procurement(){return $this->hasOneModel('Procurement');}
    public function procurements(){return $this->hasManyModel('Procurement');}
}
