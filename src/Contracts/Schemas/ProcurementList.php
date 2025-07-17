<?php

namespace Hanafalah\ModuleProcurement\Contracts\Schemas;

use Hanafalah\ModuleProcurement\Contracts\Data\ProcurementListData;
//use Hanafalah\ModuleProcurement\Contracts\Data\ProcurementListUpdateData;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModuleProcurement\Schemas\ProcurementList
 * @method self setParamLogic(string $logic, bool $search_value = false, ?array $optionals = [])
 * @method self conditionals(mixed $conditionals)
 * @method array updateProcurementList(?ProcurementListData $procurement_list_dto = null)
 * @method Model prepareUpdateProcurementList(ProcurementListData $procurement_list_dto)
 * @method bool deleteProcurementList()
 * @method bool prepareDeleteProcurementList(? array $attributes = null)
 * @method mixed getProcurementList()
 * @method ?Model prepareShowProcurementList(?Model $model = null, ?array $attributes = null)
 * @method array showProcurementList(?Model $model = null)
 * @method Collection prepareViewProcurementListList()
 * @method array viewProcurementListList()
 * @method LengthAwarePaginator prepareViewProcurementListPaginate(PaginateData $paginate_dto)
 * @method array viewProcurementListPaginate(?PaginateData $paginate_dto = null)
 * @method array storeProcurementList(?ProcurementListData $procurement_list_dto = null);
 * @method Builder procurementList(mixed $conditionals = null);
 */

interface ProcurementList extends DataManagement
{
    public function prepareStoreProcurementList(ProcurementListData $procurement_list_dto): Model;
}