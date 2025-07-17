<?php

namespace Hanafalah\ModuleProcurement\Data;

use Hanafalah\LaravelSupport\Supports\Data;
use Hanafalah\ModuleProcurement\Contracts\Data\ProcurementServiceData as DataProcurementServiceData;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;

class ProcurementServiceData extends Data implements DataProcurementServiceData
{
    #[MapInputName('id')]
    #[MapName('id')]
    public mixed $id = null;

    #[MapInputName('procurement_id')]
    #[MapName('procurement_id')]
    public mixed $procurement_id = null;

    #[MapInputName('service_id')]
    #[MapName('service_id')]
    public mixed $service_id = null;

    #[MapInputName('props')]
    #[MapName('props')]
    public ?array $props = null;

    public function after(ProcurementServiceData $data) : ProcurementServiceData{
        $data->props['prop_service'] = [
            'id'   => $data->service_id ?? null,
            'name' => null
        ];
        if (isset($data->service_id)){
            $service = self::new()->ServiceModel()->findOrFail($data->service_id);
            $data->props['prop_service']['name'] = $service->name;
        }
        return $data;
    }
}