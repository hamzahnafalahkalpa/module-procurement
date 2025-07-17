<?php

namespace Hanafalah\ModuleProcurement\Contracts\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\ModuleProcurement\Contracts\Data\ProcurementData;

/**
 * @see \Hanafalah\ModuleProcurement\Schemas\Procurement
 * @method bool deleteProcurement()
 * @method bool prepareDeleteProcurement(? array $attributes = null)
 * @method mixed getProcurement()
 * @method array storeProcurement(? ProcurementData $procurement_dto = null)
 * @method ?Model prepareShowProcurement(?Model $model = null, ?array $attributes = null)
 * @method array showProcurement(?Model $model = null)
 * @method Collection prepareViewProcurementList()
 * @method array viewProcurementList()
 * @method LengthAwarePaginator prepareViewProcurementPaginate(PaginateData $paginate_dto)
 * @method array viewProcurementPaginate(?PaginateData $paginate_dto = null)
 */
interface Procurement extends DataManagement
{
    public function prepareStoreProcurement(ProcurementData $procurement_dto): Model;
    public function prepareMainReportProcurement(Model $procurement): Model;
    public function prepareReportProcurement(?array $attributes = null): Model;
    public function reportProcurement(): array;
    public function procurement(mixed $morphs = null, mixed $conditionals = null): Builder;
}
