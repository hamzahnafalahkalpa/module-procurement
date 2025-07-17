<?php

namespace Hanafalah\ModuleProcurement\Commands;

class InstallMakeCommand extends EnvironmentCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module-procurement:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command ini digunakan untuk installing awal procurement module';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $provider = 'Hanafalah\ModuleProcurement\ModuleProcurementServiceProvider';

        $this->callSilent('vendor:publish', [
            '--provider' => $provider,
            '--tag' => 'migrations',
        ]);
        $this->info('✔️  Created migrations');

        $this->comment('hanafalah/module-procurement installed successfully.');
    }
}
