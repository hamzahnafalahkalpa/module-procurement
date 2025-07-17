<?php

namespace Hanafalah\ModuleProcurement\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleProcurement\Contracts\Data\PurchasingPropsData as DataPurchasingPropsData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class PurchasingPropsData extends Data implements DataPurchasingPropsData
{
    #[MapInputName('approval')]
    #[MapName('approval')]
    public ?ApprovalData $approval = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;
}