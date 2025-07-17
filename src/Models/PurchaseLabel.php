<?php

namespace Hanafalah\ModuleProcurement\Models;

use Hanafalah\ModuleItem\Models\ItemStuff;
use Hanafalah\ModuleProcurement\Resources\PurchaseLabel\{
    ViewPurchaseLabel, ShowPurchaseLabel
};

class PurchaseLabel extends ItemStuff
{
    protected $table = 'unicodes';
    
    public function getViewResource(){
        return ViewPurchaseLabel::class;
    }

    public function getShowResource(){
        return ShowPurchaseLabel::class;
    }
}
