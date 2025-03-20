<?php

use Zahzah\ModuleProcurement\Commands;
use Zahzah\ModuleProcurement\Models as ModuleProcurement;

return [
    'commands' => [
        Commands\InstallMakeCommand::class,
    ],
    'database' => [
        'models' => [
            'Procurement' => ModuleProcurement\Procurement::class,
            'Supplier' => ModuleProcurement\Supplier::class,
        ],
    ],
    'warehouse' => null, //add your warehouse model here
    'author' => null, //add your employee model here
    'selling_price_update_method' => 'Maximum' //'Minimum','Average'
];
