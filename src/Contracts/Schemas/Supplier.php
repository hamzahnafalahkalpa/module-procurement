<?php

namespace Hanafalah\ModuleProcurement\Contracts\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModuleOrganization\Contracts\Schemas\Organization;
use Hanafalah\ModuleProcurement\Contracts\Data\SupplierData;

/**
 * @see \Hanafalah\ModuleProcurement\Schemas\Supplier
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method mixed export(string $type)
 * @method bool deleteSupplier()
 * @method bool prepareDeleteSupplier(? array $attributes = null)
 * @method mixed getSupplier()
 * @method ?Model prepareShowSupplier(?Model $model = null, ?array $attributes = null)
 * @method array showSupplier(?Model $model = null)
 * @method Collection prepareViewSupplierList()
 * @method array viewSupplierList()
 * @method LengthAwarePaginator prepareViewSupplierPaginate(PaginateData $paginate_dto)
 * @method array viewSupplierPaginate(?PaginateData $paginate_dto = null)
 * @method array storeSupplier(?SupplierData $supplier_dto = null);
 * @method Builder supplier(mixed $conditionals = null);
 */
interface Supplier extends Organization
{
    public function prepareStoreSupplier(SupplierData $supplier_dto): Model;
}
