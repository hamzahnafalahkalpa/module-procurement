<?php

namespace Hanafalah\ModuleProcurement\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleProcurement\Contracts\Data\PurchaseOrderPropsData as DataPurchaseOrderPropsData;
use Hanafalah\ModuleTax\Contracts\Data\TaxData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class PurchaseOrderPropsData extends Data implements DataPurchaseOrderPropsData
{
    #[MapInputName('tax')]
    #[MapName('tax')]
    public ?TaxData $tax = null;

    #[MapInputName('approval')]
    #[MapName('approval')]
    public ?ApprovalData $approval = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;
}