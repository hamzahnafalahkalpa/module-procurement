<?php

namespace Hanafalah\ModuleProcurement\Supports;

use Hanafalah\LaravelSupport\Contracts\Supports\DataManagement;
use Hanafalah\LaravelSupport\Supports\PackageManagement;

class BaseModuleProcurement extends PackageManagement implements DataManagement
{
    /** @var array */
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
}
