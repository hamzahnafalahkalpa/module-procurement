<?php

namespace Hanafalah\ModuleProcurement\Contracts\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModuleProcurement\Contracts\Data\SupplierData;

/**
 * @see \Hanafalah\ModuleProcurement\Schemas\Supplier
 * @method bool deleteSupplier()
 * @method bool prepareDeleteSupplier(? array $attributes = null)
 * @method mixed getSupplier()
 * @method ?Model prepareShowSupplier(?Model $model = null, ?array $attributes = null)
 * @method array showSupplier(?Model $model = null)
 * @method Collection prepareViewSupplierList()
 * @method array viewSupplierList()
 * @method LengthAwarePaginator prepareViewSupplierPaginate(PaginateData $paginate_dto)
 * @method array viewSupplierPaginate(?PaginateData $paginate_dto = null)
 */
interface Supplier extends DataManagement
{
    public function prepareStoreSupplier(SupplierData $supplier_dto): Model;
    public function storeSupplier(?SupplierData $supplier_dto = null): array;
    public function supplier(mixed $conditionals = null): Builder;
}
