<?php

namespace Hanafalah\ModuleProcurement\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModuleProcurement\Contracts\Data\{
    PurchasingData, PurchasingUpdateData
};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModuleProcurement\Schemas\Purchasing
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method bool updatePurchasing()
 * @method bool deletePurchasing()
 * @method bool prepareDeletePurchasing(? array $attributes = null)
 * @method mixed getPurchasing()
 * @method ?Model prepareShowPurchasing(?Model $model = null, ?array $attributes = null)
 * @method array showPurchasing(?Model $model = null)
 * @method Collection prepareViewPurchasingList()
 * @method array viewPurchasingList()
 * @method LengthAwarePaginator prepareViewPurchasingPaginate(PaginateData $paginate_dto)
 * @method array viewPurchasingPaginate(?PaginateData $paginate_dto = null)
 * @method array storePurchasing(?PurchasingData $purchasing_dto = null)
 * @method Builder function purchasing(mixed $conditionals = null)
 */

interface Purchasing extends DataManagement
{
    public function prepareStorePurchasing(PurchasingData $purchasing_dto): Model;
    public function prepareUpdatePurchasing(PurchasingUpdateData $purchasing_dto): Model;
}