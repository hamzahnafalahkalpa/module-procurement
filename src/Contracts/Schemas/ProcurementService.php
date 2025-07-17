<?php

namespace Hanafalah\ModuleProcurement\Contracts\Schemas;

use Hanafalah\ModuleProcurement\Contracts\Data\ProcurementServiceData;
//use Hanafalah\ModuleProcurement\Contracts\Data\ProcurementServiceUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModuleProcurement\Schemas\ProcurementService
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method array updateProcurementService(?ProcurementServiceData $procurement_service_dto = null)
 * @method Model prepareUpdateProcurementService(ProcurementServiceData $procurement_service_dto)
 * @method bool deleteProcurementService()
 * @method bool prepareDeleteProcurementService(? array $attributes = null)
 * @method mixed getProcurementService()
 * @method ?Model prepareShowProcurementService(?Model $model = null, ?array $attributes = null)
 * @method array showProcurementService(?Model $model = null)
 * @method Collection prepareViewProcurementServiceList()
 * @method array viewProcurementServiceList()
 * @method LengthAwarePaginator prepareViewProcurementServicePaginate(PaginateData $paginate_dto)
 * @method array viewProcurementServicePaginate(?PaginateData $paginate_dto = null)
 * @method array storeProcurementService(?ProcurementServiceData $procurement_service_dto = null);
 * @method Builder procurementService(mixed $conditionals = null);
 */

interface ProcurementService extends DataManagement
{
    public function prepareStoreProcurementService(ProcurementServiceData $procurement_service_dto): Model;
}