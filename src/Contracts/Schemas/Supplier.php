<?php

namespace Hanafalah\ModuleProcurement\Contracts\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;

interface Supplier extends DataManagement
{
    public function getSupplier(): mixed;
    public function prepareShowSupplier(?Model $model = null): ?Model;
    public function showSupplier(?Model $model = null): array;
    public function prepareStoreSupplier(mixed $attributes = null): Model;
    public function storeSupplier(): array;
    public function prepareDeleteSupplier(mixed $attributes = null): Model;
    public function deleteSupplier(): array;
    public function prepareViewSupplierList(mixed $attributes = null): Collection;
    public function viewSupplierList(): array;
    public function supplier(mixed $conditionals = null): Builder;
}
