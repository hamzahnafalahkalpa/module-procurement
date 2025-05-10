<?php

namespace Hanafalah\ModuleProcurement\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleProcurement\Contracts\Data\ProcurementData;
use Hanafalah\ModuleProcurement\Contracts\Data\PurchaseOrderData as DataPurchaseOrderData;
use Hanafalah\ModuleProcurement\Contracts\Data\PurchaseOrderPropsData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class PurchaseOrderData extends Data implements DataPurchaseOrderData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('parent_id')]
    #[MapName('parent_id')]
    public mixed $parent_id = null;

    #[MapInputName('purchasing_id')]
    #[MapName('purchasing_id')]
    public mixed $purchasing_id = null;

    #[MapInputName('supplier_type')]
    #[MapName('supplier_type')]
    public mixed $supplier_type = null;

    #[MapInputName('supplier_id')]
    #[MapName('supplier_id')]
    public mixed $supplier_id = null;

    #[MapInputName('funding_id')]
    #[MapName('funding_id')]
    public mixed $funding_id;

    #[MapInputName('procurement')]
    #[MapName('procurement')]
    public ?ProcurementData $procurement = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?PurchaseOrderPropsData $props = null;

    public static function after(mixed $data): mixed{
        $props = &$data->props->props;

        $props['prop_supplier'] = [
            'id'   => null,
            'flag' => null,
            'name' => null
        ];

        if (isset($data->supplier_id) && $data->supplier_type == 'Supplier' && !isset($props['prop_supplier']['name'])){
            $supplier = self::new()->SupplierModel()->findOrFail($data->supplier_id);
            $props['prop_supplier']['id'] = $supplier->name;
            $props['prop_supplier']['flag'] = $supplier->name;
            $props['prop_supplier']['name'] = $supplier->name;
        }

        $props['prop_funding'] = [
            'id' => $data->funding_id ?? null,
            'name' => null
        ];
        if (isset($props['prop_funding']['id']) && !isset($props['prop_funding']['name'])){
            $funding = self::new()->FundingModel()->findOrFail($props['prop_funding']['id']);
            $props['prop_funding']['name'] = $funding->name;
        }

        $props['prop_purchasing'] = [
            'id' => $data->purchasing_id ?? null,
            'name' => null
        ];

        if (isset($props['prop_purchasing']['id']) && !isset($props['prop_purchasing']['name'])){
            $purchasing = self::new()->PurchasingModel()->findOrFail($props['prop_purchasing']['id']);
            $props['prop_purchasing']['name'] = $purchasing->name;
        }

        return $data;
    }
}