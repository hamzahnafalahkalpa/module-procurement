<?php

namespace Hanafalah\ModuleProcurement\Contracts\Schemas;

use Hanafalah\ModuleItem\Contracts\Schemas\ItemStuff;
use Hanafalah\ModuleProcurement\Contracts\Data\ReceiveUnitData;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModuleProcurement\Schemas\ReceiveUnit
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updateReceiveUnit(?ReceiveUnitData $receive_unit_dto = null)
 * @method Model prepareUpdateReceiveUnit(ReceiveUnitData $receive_unit_dto)
 * @method bool deleteReceiveUnit()
 * @method bool prepareDeleteReceiveUnit(? array $attributes = null)
 * @method mixed getReceiveUnit()
 * @method ?Model prepareShowReceiveUnit(?Model $model = null, ?array $attributes = null)
 * @method array showReceiveUnit(?Model $model = null)
 * @method Collection prepareViewReceiveUnitList()
 * @method array viewReceiveUnitList()
 * @method LengthAwarePaginator prepareViewReceiveUnitPaginate(PaginateData $paginate_dto)
 * @method array viewReceiveUnitPaginate(?PaginateData $paginate_dto = null)
 * @method Model prepareStoreReceiveUnit(ReceiveUnitData $receive_unit_dto)
 * @method array storeReceiveUnit(?ReceiveUnitData $receive_unit_dto = null)
 * @method Collection prepareStoreMultipleReceiveUnit(array $datas)
 * @method array storeMultipleReceiveUnit(array $datas)
 */
interface ReceiveUnit extends ItemStuff {}