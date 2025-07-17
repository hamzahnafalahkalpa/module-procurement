<?php

namespace Hanafalah\ModuleProcurement\Data;

use Carbon\Carbon;
use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleProcurement\Contracts\Data\PurchasingPropsData;
use Hanafalah\ModuleProcurement\Contracts\Data\PurchasingUpdateData as DataPurchasingUpdateData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class PurchasingUpdateData extends Data implements DataPurchasingUpdateData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id;

    #[MapInputName('type')]
    #[MapName('type')]
    public string $type;

    #[MapInputName('reported_at')]
    #[MapName('reported_at')]
    public ?Carbon $reported_at = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?PurchasingPropsData $props = null;

}