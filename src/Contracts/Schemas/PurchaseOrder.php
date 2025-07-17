<?php

namespace Hanafalah\ModuleProcurement\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModuleProcurement\Contracts\Data\PurchaseOrderData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModuleProcurement\Schemas\PurchaseOrder
 * @method mixed export(string $type)
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method bool deletePurchaseOrder()
 * @method bool prepareDeletePurchaseOrder(? array $attributes = null)
 * @method mixed getPurchaseOrder()
 * @method array storePurchaseOrder(?PurchaseOrderData $purchasing_summary_dto = null)
 * @method ?Model prepareShowPurchaseOrder(?Model $model = null, ?array $attributes = null)
 * @method array showPurchaseOrder(?Model $model = null)
 * @method Collection prepareViewPurchaseOrderList()
 * @method array viewPurchaseOrderList()
 * @method LengthAwarePaginator prepareViewPurchaseOrderPaginate(PaginateData $paginate_dto)
 * @method array viewPurchaseOrderPaginate(?PaginateData $paginate_dto = null)
 * @method Builder purchaseOrder(mixed $conditionals = null)
 */

interface PurchaseOrder extends DataManagement
{
    public function prepareStorePurchaseOrder(PurchaseOrderData $purchasing_summary_dto): Model;
}