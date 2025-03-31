<?php

namespace Hanafalah\ModuleProcurement\Contracts\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModuleProcurement\Contracts\Data\SupplierData;

interface Supplier extends DataManagement
{
    public function getSupplier(): mixed;
    public function prepareShowSupplier(?Model $model = null, ?array $attributes = null): ?Model;
    public function showSupplier(?Model $model = null): array;
    public function prepareStoreSupplier(SupplierData $supplier_dto): Model;
    public function storeSupplier(?SupplierData $supplier_dto = null): array;
    public function prepareViewSupplierList(mixed $attributes = null): Collection;
    public function viewSupplierList(): array;
    public function prepareDeleteSupplier(? array $attributes = null): bool;
    public function deleteSupplier(): bool;
    public function supplier(mixed $conditionals = null): Builder;
    
}
