<?php

namespace Hanafalah\ModuleProcurement\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleProcurement\Contracts\Data\ProcurementData;
use Hanafalah\ModuleProcurement\Contracts\Data\PurchaseOrderData as DataPurchaseOrderData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class PurchaseOrderData extends Data implements DataPurchaseOrderData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('purchasing_id')]
    #[MapName('purchasing_id')]
    public mixed $purchasing_id = null;

    #[MapInputName('supplier_id')]
    #[MapName('supplier_id')]
    public mixed $supplier_id;

    #[MapInputName('funding_id')]
    #[MapName('funding_id')]
    public mixed $funding_id;

    #[MapInputName('procurement')]
    #[MapName('procurement')]
    public ?ProcurementData $procurement = null;

    #[MapInputName('tax')]
    #[MapName('tax')]
    public ?float $tax = 0;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;

    public static function after(PurchaseOrderData $data): PurchaseOrderData{
        $data->props['prop_supplier'] = [
            'id' => $data->supplier_id ?? null,
            'name' => null
        ];

        if (isset($data->props['prop_supplier']['id']) && !isset($data->props['prop_supplier']['name'])){
            $supplier = self::new()->SupplierModel()->findOrFail($data->props['prop_supplier']['id']);
            $data->props['prop_supplier']['name'] = $supplier->name;
        }

        $data->props['prop_funding'] = [
            'id' => $data->funding_id ?? null,
            'name' => null
        ];
        if (isset($data->props['prop_funding']['id']) && !isset($data->props['prop_funding']['name'])){
            $funding = self::new()->FundingModel()->findOrFail($data->props['prop_funding']['id']);
            $data->props['prop_funding']['name'] = $funding->name;
        }

        $data->props['prop_purchasing'] = [
            'id' => $data->purchasing_id ?? null,
            'name' => null
        ];

        if (isset($data->props['prop_purchasing']['id']) && !isset($data->props['prop_purchasing']['name'])){
            $purchasing = self::new()->PurchasingModel()->findOrFail($data->props['prop_purchasing']['id']);
            $data->props['prop_purchasing']['name'] = $purchasing->name;
        }
        return $data;
    }
}