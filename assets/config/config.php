<?php

use Hanafalah\ModuleProcurement\Commands;

return [
    'namespace' => 'Hanafalah\\ModuleProcurement',
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
    'commands' => [
        Commands\InstallMakeCommand::class,
    ],
    'warehouse' => null, //add your warehouse model here
    'author' => null, //add your employee model here
    'selling_price_update_method' => 'Maximum' //'Minimum','Average'
];
