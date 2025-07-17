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

    public static function before(array &$attributes){
        $procurement = &$attributes['procurement'];
        $attributes['approving'] ??= false;
        if ($attributes['approving']) {
            $procurement['approved_at'] ??= now();
            $procurement['is_approved'] = true;
            $attributes['reporting'] = true;
        }
        $attributes['reporting'] ??= false;
        if ($attributes['reporting']) {
            $procurement['reported_at'] ??= now();
            $procurement['is_reported'] = true;
        }
        $procurement['name'] = $attributes['name'];
    }

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