<?php

namespace Hanafalah\ModuleProcurement\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleProcurement\Contracts\Data\ReceiveOrderData as DataReceiveOrderData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\Validation\DateFormat;

class ReceiveOrderData extends Data implements DataReceiveOrderData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('name')]
    #[MapName('name')]
    public string $name;

    #[MapInputName('received_at')]
    #[MapName('received_at')]
    #[DateFormat('Y-m-d')]
    public ?string $received_at;

    #[MapInputName('purchasing_id')]
    #[MapName('purchasing_id')]
    public mixed $purchasing_id;

    #[MapInputName('purchase_order_id')]
    #[MapName('purchase_order_id')]
    public mixed $purchase_order_id;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;
}