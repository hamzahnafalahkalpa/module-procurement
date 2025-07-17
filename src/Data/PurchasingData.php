<?php

namespace Hanafalah\ModuleProcurement\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleProcurement\Contracts\Data\ProcurementData;
use Hanafalah\ModuleProcurement\Contracts\Data\PurchasingData as DataPurchasingData;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class PurchasingData extends Data implements DataPurchasingData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('name')]
    #[MapName('name')]
    public string $name;

    #[MapInputName('note')]
    #[MapName('note')]
    public ?string $note = null;

    #[MapInputName('purchase_request_ids')]
    #[MapName('purchase_request_ids')]
    public ?array $purchase_request_ids = [];

    #[MapInputName('procurement')]
    #[MapName('procurement')]
    public ?ProcurementData $procurement = null;

    #[MapInputName('purchase_orders')]
    #[MapName('purchase_orders')]
    #[DataCollectionOf(PurchaseOrderData::class)]
    public ?array $purchase_orders = [];

    #[MapInputName('props')]
    #[MapName('props')]
    public ?PurchasingPropsData $props = null;

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
}