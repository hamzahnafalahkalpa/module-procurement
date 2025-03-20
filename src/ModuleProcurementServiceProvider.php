<?php

namespace Zahzah\ModuleProcurement;

use Zahzah\LaravelSupport\Providers\BaseServiceProvider;

class ModuleProcurementServiceProvider extends BaseServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerMainClass(ModuleProcurement::class)
            ->registerCommandService(Providers\CommandServiceProvider::class)
            ->registers([
                '*',
                'Services' => function () {
                    $this->binds([
                        Contracts\Procurement::class => Schemas\Procurement::class,
                        Contracts\Supplier::class => Schemas\Supplier::class
                    ]);
                },
            ]);
    }

    protected function dir(): string
    {
        return __DIR__.'/';
    }

    protected function migrationPath(string $path = ''): string
    {
        return database_path($path);
    }
}
