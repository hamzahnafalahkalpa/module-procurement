<?php

use Hanafalah\ModuleProcurement\Commands;

return [
    'namespace' => 'Hanafalah\\LaravelPermission',
    'libs' => [
        'model' => 'Models',
        'contract' => 'Contracts',
        'schema' => 'Schemas',
        'database' => 'Database',
        'data' => 'Data',
        'resource' => 'Resources',
        'migration' => '../assets/database/migrations',
    ],
    'app' => [
        'contracts' => [
            //ADD YOUR CONTRACT MAPPER HERE
        ]
    ],
    'database' => [
        'models' => [
            //ADD YOUR MODEL MAPPER HERE
        ],
    ],
    'commands' => [
        Commands\InstallMakeCommand::class,
    ],
    'warehouse' => null, //add your warehouse model here
    'author'    => null, //add your employee model here
    'approval'  => null,
    'selling_price_update_method' => 'Average' //'Minimum','Average'
];
