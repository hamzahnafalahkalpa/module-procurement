<?php

namespace Hanafalah\ModuleProcurement\Data;

use Hanafalah\LaravelSupport\Supports\Data;
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

    #[MapInputName('approval')]
    #[MapName('approval')]
    public ?ApprovalData $approval = null;
}