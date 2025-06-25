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

    #[MapInputName('received_address')]
    #[MapName('received_address')]
    public ?string $received_address = null;

    #[MapInputName('procurement')]
    #[MapName('procurement')]
    public ?ProcurementData $procurement = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?PurchaseOrderPropsData $props = null;

    public static function after(mixed $data): mixed{
        $new = static::new();
        $props = &$data->props->props;

        $supplier = $new->SupplierModel();
        if (isset($data->supplier_id) && $data->supplier_type == 'Supplier') $supplier = $supplier->findOrFail($data->supplier_id);
        $props['prop_supplier'] = $supplier->toViewApi()->only(['id','flag','name']);
        
        $funding = $new->SupplierModel();
        if (isset($props['prop_funding']['id']) && !isset($props['prop_funding']['name'])) $funding = $funding->findOrFail($data->supplier_id);
        $props['prop_funding'] = $funding->toViewApi()->only(['id','name']);

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