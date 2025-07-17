<?php

namespace Hanafalah\ModuleProcurement\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleProcurement\Contracts\Data\ProcurementPropsData as DataProcurementPropsData;
use Hanafalah\ModuleTax\Contracts\Data\TaxData;
use Hanafalah\ModuleTax\Contracts\Data\TotalTaxData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class ProcurementPropsData extends Data implements DataProcurementPropsData{
    #[MapName('total_tax')] 
    #[MapInputName('total_tax')] 
    public ?TotalTaxData $total_tax = null;

    #[MapName('tax')] 
    #[MapInputName('tax')] 
    public ?TaxData $tax = null;

    #[MapName('props')] 
    #[MapInputName('props')] 
    public ?array $props = null;
}