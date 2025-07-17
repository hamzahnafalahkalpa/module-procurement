<?php

namespace Hanafalah\ModuleProcurement\Models;

use Hanafalah\ModuleItem\Models\ItemStuff;
use Hanafalah\ModuleProcurement\Resources\ReceiveUnit\{
    ViewReceiveUnit,
    ShowReceiveUnit
};

class ReceiveUnit extends ItemStuff
{
    protected $table = 'unicodes';
    
    public function getViewResource(){
        return ViewReceiveUnit::class;
    }

    public function getShowResource(){
        return ShowReceiveUnit::class;
    }
}
