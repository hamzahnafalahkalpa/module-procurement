<?php

namespace Hanafalah\ModuleProcurement\Data;

use Hanafalah\ModuleProcurement\Contracts\Data\PurchaseOrderData;
use Hanafalah\ModuleProcurement\Contracts\Data\WorkOrderData as DataWorkOrderData;
use Hanafalah\ModuleProcurement\Data\PurchaseOrderData as DataPurchaseOrderData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class WorkOrderData extends DataPurchaseOrderData implements DataWorkOrderData
{
    #[MapInputName('purchase_orders')]
    #[MapName('purchase_orders')]
    #[DataCollectionOf(PurchaseOrderData::class)]
    public ?array $purchase_orders = [];

    public static function after(mixed $data): mixed{
        parent::after($data);
        $props = &$data->props->props;

        $sub_contractor = self::new()->SubContractorModel();
        if (isset($data->supplier_id) && $data->supplier_type == 'SubContractor'){
            $sub_contractor = $sub_contractor->findOrFail($data->supplier_id);
            $props['prop_supplier'] = $sub_contractor->toViewApi()->resolve();
        }
        $props['prop_sub_contractor'] = $sub_contractor->toViewApi()->resolve();
        return $data;
    }
}