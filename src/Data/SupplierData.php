<?php

namespace Hanafalah\ModuleProcurement\Data;

use Hanafalah\ModuleOrganization\Data\OrganizationData;
use Hanafalah\ModuleProcurement\Contracts\Data\SupplierData as DataSupplierData;

class SupplierData extends OrganizationData implements DataSupplierData{
    public static function before(array &$attributes){
        $attributes['flag'] ??= 'Supplier';
        parent::before($attributes);
    }
}