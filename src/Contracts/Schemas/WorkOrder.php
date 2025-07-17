<?php

namespace Hanafalah\ModuleProcurement\Contracts\Schemas;

use Hanafalah\ModuleProcurement\Contracts\Data\WorkOrderData;
//use Hanafalah\ModuleProcurement\Contracts\Data\WorkOrderUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModuleProcurement\Schemas\WorkOrder
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method array updateWorkOrder(?WorkOrderData $work_order_dto = null)
 * @method Model prepareUpdateWorkOrder(WorkOrderData $work_order_dto)
 * @method bool deleteWorkOrder()
 * @method bool prepareDeleteWorkOrder(? array $attributes = null)
 * @method mixed getWorkOrder()
 * @method ?Model prepareShowWorkOrder(?Model $model = null, ?array $attributes = null)
 * @method array showWorkOrder(?Model $model = null)
 * @method Collection prepareViewWorkOrderList()
 * @method array viewWorkOrderList()
 * @method LengthAwarePaginator prepareViewWorkOrderPaginate(PaginateData $paginate_dto)
 * @method array viewWorkOrderPaginate(?PaginateData $paginate_dto = null)
 * @method array storeWorkOrder(?WorkOrderData $work_order_dto = null);
 * @method Builder workOrder(mixed $conditionals = null);
 */

interface WorkOrder extends PurchaseOrder
{
    public function prepareStoreWorkOrder(WorkOrderData $work_order_dto): Model;
}