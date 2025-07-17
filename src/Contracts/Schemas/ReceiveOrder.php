<?php

namespace Hanafalah\ModuleProcurement\Contracts\Schemas;

use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModuleProcurement\Contracts\Data\ReceiveOrderData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModuleProcurement\Schemas\ReceiveOrder
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method bool deleteReceiveOrder()
 * @method bool prepareDeleteReceiveOrder(? array $attributes = null)
 * @method mixed getReceiveOrder()
 * @method array storeReceiveOrder(?ReceiveOrderData $receive_order_dto = null)
 * @method ?Model prepareShowReceiveOrder(?Model $model = null, ?array $attributes = null)
 * @method array showReceiveOrder(?Model $model = null)
 * @method Collection prepareViewReceiveOrderList()
 * @method array viewReceiveOrderList()
 * @method LengthAwarePaginator prepareViewReceiveOrderPaginate(PaginateData $paginate_dto)
 * @method array viewReceiveOrderPaginate(?PaginateData $paginate_dto = null)
 * @method Builder receiveOrder(mixed $conditionals = null)
 */

interface ReceiveOrder extends DataManagement
{
    public function prepareStoreReceiveOrder(ReceiveOrderData $receive_order_dto): Model;
}