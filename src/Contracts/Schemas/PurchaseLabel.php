<?php

namespace Hanafalah\ModuleProcurement\Contracts\Schemas;

use Hanafalah\ModuleItem\Contracts\Schemas\ItemStuff;
use Hanafalah\ModuleProcurement\Contracts\Data\PurchaseLabelData;
use Illuminate\Database\Eloquent\Model;

/**
 * @see \Hanafalah\ModuleProcurement\Schemas\PurchaseLabel
 * @method mixed export(string $type)
 * @method self conditionals(mixed $conditionals)
 * @method array updatePurchaseLabel(?PurchaseLabelData $purchase_label_dto = null)
 * @method Model prepareUpdatePurchaseLabel(PurchaseLabelData $purchase_label_dto)
 * @method bool deletePurchaseLabel()
 * @method bool prepareDeletePurchaseLabel(? array $attributes = null)
 * @method mixed getPurchaseLabel()
 * @method ?Model prepareShowPurchaseLabel(?Model $model = null, ?array $attributes = null)
 * @method array showPurchaseLabel(?Model $model = null)
 * @method Collection prepareViewPurchaseLabelList()
 * @method array viewPurchaseLabelList()
 * @method LengthAwarePaginator prepareViewPurchaseLabelPaginate(PaginateData $paginate_dto)
 * @method array viewPurchaseLabelPaginate(?PaginateData $paginate_dto = null)
 * @method Model prepareStorePurchaseLabel(PurchaseLabelData $purchase_label_dto)
 * @method array storePurchaseLabel(?PurchaseLabelData $purchase_label_dto = null)
 * @method Collection prepareStoreMultiplePurchaseLabel(array $datas)
 * @method array storeMultiplePurchaseLabel(array $datas)
 */
interface PurchaseLabel extends ItemStuff{}