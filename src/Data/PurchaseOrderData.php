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

    #[MapInputName('name')]
    #[MapName('name')]
    public ?string $name = null;

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

    public static function before(array &$attributes){
        $procurement = &$attributes['procurement'];
        $attributes['reporting'] ??= false;
        if ($attributes['reporting']) {
            $procurement['reported_at'] ??= now();
            $procurement['is_reported'] = true;
        }
    }

    public static function after(mixed $data): mixed{
        $new = static::new();
        $props = &$data->props->props;

        $data->supplier_type ??= 'Supplier';
        $supplier = $new->{$data->supplier_type.'Model'}();
        if (isset($data->supplier_id)) $supplier = $supplier->findOrFail($data->supplier_id);
        $props['prop_supplier'] = $supplier->toViewApi()->resolve();
        
        $funding = $new->FundingModel();
        if (isset($data->funding_id)) $funding = $funding->findOrFail($data->funding_id);
        $props['prop_funding'] = $funding->toViewApi()->resolve();

        $purchasing = $new->PurchasingModel();
        if (isset($data->purchasing_id)) $purchasing = $purchasing->findOrFail($data->purchasing_id);
        $props['prop_purchasing'] = $purchasing->toViewApi()->resolve();

        return $data;
    }
}