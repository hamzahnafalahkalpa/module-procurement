<?php

namespace Hanafalah\ModuleProcurement\Schemas;

use Hanafalah\ModuleItem\Schemas\ItemStuff;
use Hanafalah\ModuleProcurement\Contracts\Schemas\PurchaseLabel as ContractsPurchaseLabel;

class PurchaseLabel extends ItemStuff implements ContractsPurchaseLabel
{
    protected string $__entity = 'PurchaseLabel';
    public $purchase_label_model;
    //protected mixed $__order_by_created_at = false; //asc, desc, false

    protected array $__cache = [
        'index' => [
            'name'     => 'purchase_label',
            'tags'     => ['purchase_label', 'purchase_label-index'],
            'duration' => 24 * 60
        ]
    ];
}