<?php

namespace Hanafalah\ModuleProcurement\Schemas;

use Hanafalah\ModuleProcurement\Contracts\Schemas\Supplier as ContractsSupplier;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleOrganization\Schemas\Organization;
use Hanafalah\ModuleProcurement\Contracts\Data\SupplierData;

class Supplier extends Organization implements ContractsSupplier
{
    protected string $__entity = 'Supplier';
    public $supplier_model;
    protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'supplier',
            'tags'     => ['supplier', 'supplier-index'],
            'duration' => 24 * 60
        ],
    ];

    public function prepareStoreSupplier(SupplierData $supplier_dto): Model{
        $supplier = $this->prepareStoreOrganization($supplier_dto);
        return $this->supplier_model = $supplier;
    }
}
