<?php
namespace Qnv\Repository;

use Illuminate\Support\ServiceProvider;
use Qnv\Repository\Commands\RepositoryMakeClassCommand;
use Qnv\Repository\Commands\RepositoryMakeCommand;
use Qnv\Repository\Commands\RepositoryMakeInterfaceCommand;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootCommands();
        $this->bootPublishes();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (! $this->app->configurationIsCached()) {
            $this->mergeConfigFrom(__DIR__.'/../config/qnv-repository.php', 'qnv-repository');
        }
    }

    /**
     * Boot the custom commands
     *
     * @return void
     */
    private function bootCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                RepositoryMakeClassCommand::class,
                RepositoryMakeInterfaceCommand::class,
                RepositoryMakeCommand::class
            ]);
        }
    }
    private function bootPublishes(){
        $this->publishes([
            __DIR__.'/../config/qnv-repository.php' => $this->app->configPath('qnv-repository.php'),
        ], 'qnv-repository-config');
    }
}
