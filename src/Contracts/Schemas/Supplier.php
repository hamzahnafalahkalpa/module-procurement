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
 * @method array storeSupplier(?SupplierData $supplier_dto = null);
 * @method Builder supplier(mixed $conditionals = null);
 */
interface Supplier extends DataManagement
{
    public function prepareStoreSupplier(SupplierData $supplier_dto): Model;
}
