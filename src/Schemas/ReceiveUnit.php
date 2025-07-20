<?php

namespace Hanafalah\ModuleProcurement\Schemas;

use Hanafalah\ModuleItem\Schemas\ItemStuff;
use Hanafalah\ModuleProcurement\Contracts\Schemas\ReceiveUnit as ContractsReceiveUnit;

class ReceiveUnit extends ItemStuff implements ContractsReceiveUnit
{
    protected string $__entity = 'ReceiveUnit';
    public $receive_unit_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'receive_unit',
            'tags'     => ['receive_unit', 'receive_unit-index'],
            'duration' => 24 * 60
        ]
    ];
}