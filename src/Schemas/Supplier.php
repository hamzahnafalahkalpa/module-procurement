<?php

namespace Hanafalah\ModuleProcurement\Schemas;

use Hanafalah\ModuleProcurement\Contracts\Supplier as ContractsSupplier;
use Hanafalah\ModuleProcurement\Resources\Supplier\ShowSupplier;
use Hanafalah\ModuleProcurement\Resources\Supplier\ViewSupplier;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Supports\PackageManagement;

class Supplier extends PackageManagement implements ContractsSupplier
{
    protected array $__guard = ['id'];
    protected array $__add = ['name', 'phone', 'address'];
    protected string $__entity = 'Supplier';
    public static $supplier_model;

    protected array $__resources = [
        'view' => ViewSupplier::class,
        'show' => ShowSupplier::class,
    ];

    protected array $__cache = [
        'index' => [
            'name' => 'supplier',
            'tags' => ['supplier', 'supplier-index'],
            'forever' => true,
        ],
    ];



    public function getSupplier(): mixed
    {
        return static::$supplier_model;
    }

    public function prepareShowSupplier(?Model $model = null): ?Model
    {
        $model ??= $this->getSupplier();
        if (!isset($model)) {
            $id = request()->id;
            if (! request()->has('id')) {
                throw new \Exception('No id provided', 422);
            }
            $model = $this->supplier()->find($id);
        }

        return static::$supplier_model = $model;
    }

    public function showSupplier(?Model $model = null): array
    {
        return $this->transforming($this->__resources['show'], $this->prepareShowSupplier($model));
    }

    public function prepareStoreSupplier(mixed $attributes = null): Model
    {
        $attributes ??= request()->all();

        $supplier = $this->SupplierModel()->updateOrCreate([
            'id' => $attributes['id'] ?? null,
        ], [
            'name'    => $attributes['name'],
            'phone'   => $attributes['phone'],
            'address' => $attributes['address'] ?? null,
        ]);
        if (isset($attributes['jurnal'])) {
            $supplier->jurnal = $attributes['jurnal'];
            $supplier->save();
        }
        $this->forgetTags('supplier');
        return static::$supplier_model = $supplier;
    }

    public function storeSupplier(): array
    {
        return $this->transaction(function () {
            return $this->showSupplier($this->prepareStoreSupplier());
        });
    }

    public function prepareViewSupplierList(mixed $attributes = null): Collection
    {
        $attributes ??= request()->all();
        return static::$supplier_model = $this->cacheWhen(!$this->isSearch(), $this->__cache['index'], function () {
            return $this->supplier()->get();
        });
    }

    public function viewSupplierList(): array
    {
        return $this->transforming($this->__resources['view'], function () {
            return $this->prepareViewSupplierList();
        });
    }

    public function removeById(mixed $id = null): bool
    {
        $id ??= request()->id;

        return $this->transaction(function () use ($id) {
            $deleted = $this->supplier()->find($id)->delete();
            $this->forgetTags('supplier');
            return $deleted;
        });
    }

    public function supplier(mixed $conditionals = null): Builder
    {
        $this->booting();

        return $this->SupplierModel()->conditionals($conditionals)->withParameters()->orderBy('name', 'asc');
    }
}
