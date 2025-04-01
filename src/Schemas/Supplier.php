<?php

namespace Hanafalah\ModuleProcurement\Schemas;

use Hanafalah\ModuleProcurement\Contracts\Schemas\Supplier as ContractsSupplier;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
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

    protected function viewUsingRelation(): array{
        return [];
    }

    protected function showUsingRelation(): array{
        return [];
    }

    public function getSupplier(): mixed{
        return static::$supplier_model;
    }

    public function prepareShowSupplier(?Model $model = null, ?array $attributes = null): ?Model{
        $attributes ??= request()->all();
        $model      ??= $this->getSupplier();
        if (!isset($model)) {
            $id = $attributes['id'] ?? null;
            if (!isset($id)) throw new \Exception('No id provided', 422);
            $model = $this->supplier()->with($this->showUsingRelation())->findOrFail($id);
        }else{
            $model->load($this->showUsingRelation());
        }

        return static::$supplier_model = $model;
    }

    public function showSupplier(?Model $model = null): array{
        return $this->showEntityResource(function() use ($model){
            return $this->prepareShowSupplier($model);
        });
    }

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

    public function prepareViewSupplierList(mixed $attributes = null): Collection{
        return static::$supplier_model = $this->cacheWhen(!$this->isSearch(), $this->__cache['index'], function () {
            return $this->supplier()->get();
        });
    }

    public function viewSupplierList(): array{
        return $this->viewEntityResource(function(){
            return $this->prepareViewSupplierList();
        });
    }

    public function prepareDeleteSupplier(? array $attributes = null): bool
    {
        $attributes ??= \request()->all();
        if (!isset($attributes['id'])) throw new \Exception('No id provided', 422);

        $model = $this->supplier()->findOrFail($attributes['id']);
        $result = $model->delete();
        $this->forgetTags('supplier');
        return $result;
    }

    public function deleteSupplier(): bool{
        return $this->transaction(function(){
            return $this->prepareDeleteSupplier();
        });
    }

    public function supplier(mixed $conditionals = null): Builder{
        $this->booting();

        return $this->SupplierModel()->conditionals($this->mergeCondition($conditionals ?? []))->withParameters()->orderBy('name', 'asc');
    }
}
