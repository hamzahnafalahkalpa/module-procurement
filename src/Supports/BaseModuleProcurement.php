<?php

namespace Hanafalah\ModuleProcurement\Supports;

use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\LaravelSupport\Supports\PackageManagement;
use Illuminate\Database\Eloquent\Model;

class BaseModuleProcurement extends PackageManagement implements DataManagement
{
    protected $__config_name = 'module-procurement';
    protected $__module_procurement_config = [];

    /**
     * A description of the entire PHP function.
     *
     * @param Container $app The Container instance
     * @throws Exception description of exception
     * @return void
     */
    public function __construct()
    {
        $this->setConfig('module-procurement', $this->__module_procurement_config);
    }

    protected function initializeProcurementDTO(Model &$model, mixed &$dto){
        $model->load('procurement');
        $procurement                     = $model->procurement;
        $procurement_dto                 = &$dto->procurement;
        $procurement_dto->id             = $procurement->getKey();
        $procurement_dto->reference_type = $procurement->reference_type;
        $procurement_dto->reference_id   = $procurement->reference_id;
        $procurement_dto->status       ??= $procurement->status;
        $procurement = $this->schemaContract('procurement')->prepareStoreProcurement($procurement_dto);
        $model->load('procurement');
    }
}
