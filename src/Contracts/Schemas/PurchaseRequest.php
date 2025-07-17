<?php

namespace Hanafalah\ModuleProcurement\Contracts\Schemas;

use Hanafalah\ModuleProcurement\Contracts\Data\PurchaseRequestData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModuleProcurement\Schemas\PurchaseRequest
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method bool deletePurchaseRequest()
 * @method bool prepareDeletePurchaseRequest(? array $attributes = null)
 * @method mixed getPurchaseRequest()
 * @method array storePurchaseRequest(?PurchaseRequestData $purchase_request_dto = null)
 * @method ?Model prepareShowPurchaseRequest(?Model $model = null, ?array $attributes = null)
 * @method array showPurchaseRequest(?Model $model = null)
 * @method Collection prepareViewPurchaseRequestList()
 * @method array viewPurchaseRequestList()
 * @method LengthAwarePaginator prepareViewPurchaseRequestPaginate(PaginateData $paginate_dto)
 * @method array viewPurchaseRequestPaginate(?PaginateData $paginate_dto = null)
 * @method Builder purchaseRequest(mixed $conditionals = null)
 */

interface PurchaseRequest extends DataManagement
{
    public function prepareStorePurchaseRequest(PurchaseRequestData $purchase_request_dto): Model;
}