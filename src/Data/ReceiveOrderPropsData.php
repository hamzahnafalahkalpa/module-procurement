<?php

namespace Hanafalah\ModuleProcurement\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleProcurement\Contracts\Data\ReceiveOrderPropsData as DataReceiveOrderPropsData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class ReceiveOrderPropsData extends Data implements DataReceiveOrderPropsData
{
    #[MapInputName('form')]
    #[MapName('form')]
    public ?array $form = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;
}