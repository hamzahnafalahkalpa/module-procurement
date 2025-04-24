<?php

namespace Hanafalah\ModuleProcurement\Schemas;

use Hanafalah\ModuleProcurement\Contracts\Schemas\Supplier as ContractsSupplier;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Hanafalah\ModuleProcurement\Contracts\Data\SupplierData;

class Supplier extends PackageManagement implements ContractsSupplier
{
    protected string $__entity = 'Supplier';
    public static $supplier_model;

    protected array $__cache = [
        'index' => [
            'name' => 'supplier',
            'tags' => ['supplier', 'supplier-index'],
            'forever' => true,
        ],
    ];

    public function prepareStoreSupplier(SupplierData $supplier_dto): Model{
        $supplier = $this->SupplierModel()->updateOrCreate([
            'id' => $supplier_dto->id ?? null,
        ], [
            'name'    => $supplier_dto->name,
            'phone'   => $supplier_dto->phone ?? null,
            'address' => $supplier_dto->address ?? null,
        ]);
        $this->forgetTags('supplier');
        return static::$supplier_model = $supplier;
    }

    public function storeSupplier(?SupplierData $supplier_dto = null): array{
        return $this->transaction(function() use ($supplier_dto){
            return $this->showSupplier($this->prepareStoreSupplier($supplier_dto ?? $this->requestDTO(SupplierData::class)));
        });
    }

    public function supplier(mixed $conditionals = null): Builder{
        $this->booting();
        return $this->SupplierModel()->conditionals($this->mergeCondition($conditionals ?? []))
                    ->withParameters()->orderBy('name', 'asc');
    }
}
