<?php

namespace Hanafalah\ModuleProcurement\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModuleProcurement\Contracts\Data\PurchaseOrderData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModuleProcurement\Schemas\PurchaseOrder
 * @method self conditionals(mixed $conditionals)
 * @method bool deletePurchaseOrder()
 * @method bool prepareDeletePurchaseOrder(? array $attributes = null)
 * @method mixed getPurchaseOrder()
 * @method ?Model prepareShowPurchaseOrder(?Model $model = null, ?array $attributes = null)
 * @method array showPurchaseOrder(?Model $model = null)
 * @method Collection prepareViewPurchaseOrderList()
 * @method array viewPurchaseOrderList()
 * @method LengthAwarePaginator prepareViewPurchaseOrderPaginate(PaginateData $paginate_dto)
 * @method array viewPurchaseOrderPaginate(?PaginateData $paginate_dto = null)
 */

interface PurchaseOrder extends DataManagement
{
    public function prepareStorePurchaseOrder(PurchaseOrderData $purchasing_summary_dto): Model;
    public function storePurchaseOrder(?PurchaseOrderData $purchasing_summary_dto = null): array;
    public function purchaseOrder(mixed $conditionals = null): Builder;
}