<?php

namespace Moataz\SchemaObjectManager;

use Illuminate\Support\ServiceProvider;

use Moataz\SchemaObjectManager\Console\MakeViewCommand;
use Moataz\SchemaObjectManager\Console\SyncSchemaCommand;
use Moataz\SchemaObjectManager\Console\MakeTriggerCommand;
use Moataz\SchemaObjectManager\Console\MakeFunctionCommand;
use Moataz\SchemaObjectManager\Console\MakeProcedureCommand;

class SchemaServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/config/schema-objects.php' =>
            $this->app->configPath('schema-objects.php'),
        ], 'schema-objects');

        if ($this->app->runningInConsole()) {
            $this->commands([
                SyncSchemaCommand::class,
                MakeProcedureCommand::class,
                MakeTriggerCommand::class,
                MakeFunctionCommand::class,
                MakeViewCommand::class,
            ]);
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/schema-objects.php',
            'schema-objects'
        );
    }
}
