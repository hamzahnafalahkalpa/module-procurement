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

    #[MapInputName('tax')]
    #[MapName('tax')]
    public ?float $tax = 0;

    #[MapInputName('purchase_orders')]
    #[MapName('purchase_orders')]
    #[DataCollectionOf(PurchaseOrderData::class)]
    public ?array $purchase_orders = [];

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;
}