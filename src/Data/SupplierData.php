<?php

namespace Hanafalah\ModuleProcurement\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleProcurement\Contracts\Data\SupplierData as DataSupplierData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class SupplierData extends Data implements DataSupplierData{
    #[MapName('id')] 
    #[MapInputName('id')] 
    public mixed $id = null;

    #[MapName('name')] 
    #[MapInputName('name')] 
    public string $name;

    #[MapName('phone')] 
    #[MapInputName('phone')] 
    public ?string $phone = null;

    #[MapName('address')] 
    #[MapInputName('address')] 
    public ?string $address = null;
}