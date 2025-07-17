<?php

namespace Hanafalah\ModuleProcurement\Data;

use Hanafalah\ModuleItem\Data\ItemStuffData;
use Hanafalah\ModuleProcurement\Contracts\Data\PurchaseLabelData as DataPurchaseLabelData;

class PurchaseLabelData extends ItemStuffData implements DataPurchaseLabelData
{
    public static function before(array &$attributes){
        $attributes['flag'] ??= 'PurchaseLabel';
        parent::before($attributes);
    }
}