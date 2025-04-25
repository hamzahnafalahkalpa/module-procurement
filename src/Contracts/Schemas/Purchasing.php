<?php

namespace Hanafalah\ModuleProcurement\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModuleProcurement\Contracts\Data\PurchasingData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModuleProcurement\Schemas\Purchasing
 * @method self conditionals(mixed $conditionals)
 * @method bool deletePurchasing()
 * @method bool prepareDeletePurchasing(? array $attributes = null)
 * @method mixed getPurchasing()
 * @method ?Model prepareShowPurchasing(?Model $model = null, ?array $attributes = null)
 * @method array showPurchasing(?Model $model = null)
 * @method Collection prepareViewPurchasingList()
 * @method array viewPurchasingList()
 * @method LengthAwarePaginator prepareViewPurchasingPaginate(PaginateData $paginate_dto)
 * @method array viewPurchasingPaginate(?PaginateData $paginate_dto = null)
 */

interface Purchasing extends DataManagement
{
    public function prepareStorePurchasing(PurchasingData $purchasing_dto): Model;
    public function storePurchasing(?PurchasingData $purchasing_dto = null): array;
    public function purchasing(mixed $conditionals = null): Builder;
}