<?php

use Hanafalah\ModuleProcurement\Commands;
use Hanafalah\ModuleProcurement\Models as ModuleProcurement;

return [
    'commands' => [
        Commands\InstallMakeCommand::class,
    ],
    'libs' => [
        'model' => 'Models',
        'contract' => 'Contracts',
        'schema' => 'Schemas',
        'database' => 'Database',
        'data' => 'Data',
        'resource' => 'Resources',
        'migration' => '../assets/database/migrations'
    ],
    'app' => [
        'contracts' => []
    ],
    'database' => [
        'models' => [
        ],
    ],
    'warehouse' => null, //add your warehouse model here
    'author' => null, //add your employee model here
    'selling_price_update_method' => 'Maximum' //'Minimum','Average'
];
