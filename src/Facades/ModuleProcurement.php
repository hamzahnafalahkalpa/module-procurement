<?php

namespace Hanafalah\ModuleProcurement\Facades;

use Hanafalah\ModuleProcurement\Contracts\ModuleProcurement as ContractsModuleProcurement;

class ModuleProcurement extends \Illuminate\Support\Facades\Facade
{
  /**
   * Get the registered name of the component.
   *
   * @return string
   */
  protected static function getFacadeAccessor()
  {
    return ContractsModuleProcurement::class;
  }
}
