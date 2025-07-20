<?php

namespace Hanafalah\ModuleProcurement\Schemas;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Hanafalah\ModuleProcurement\{
    Supports\BaseModuleProcurement
};
use Hanafalah\ModuleProcurement\Contracts\Schemas\ProcurementService as ContractsProcurementService;
use Hanafalah\ModuleProcurement\Contracts\Data\ProcurementServiceData;

class ProcurementService extends BaseModuleProcurement implements ContractsProcurementService
{
    protected string $__entity = 'ProcurementService';
    public $procurement_service_model;

    protected array $__cache = [
        'index' => [
            'name'     => 'procurement_service',
            'tags'     => ['procurement_service', 'procurement_service-index'],
            'duration' => 24 * 60
        ]
    ];

    public function prepareStoreProcurementService(ProcurementServiceData $procurement_service_dto): Model{
        $procurement_service = $this->usingEntity()->updateOrCreate([
                        'id' => $procurement_service_dto->id ?? null
                    ], [
                        'service_id' => $procurement_service_dto->service_id,
                        'procurement_id' => $procurement_service_dto->procurement_id
                    ]);
        $this->fillingProps($procurement_service,$procurement_service_dto->props);
        $procurement_service->save();
        return $this->procurement_service_model = $procurement_service;
    }
}