<?php

declare(strict_types=1);

namespace Marick\LaravelClasslessMigrations;

use Illuminate\Database\Migrations\MigrationCreator;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ClasslessMigrationsServiceProvider extends LaravelServiceProvider
{
    public function register(): void
    {
        $this->app->extend('migrator', function (): ClasslessMigrator {
            return new ClasslessMigrator(
                app('migration.repository'),
                app('db'),
                app('files'),
                app('events'),
            );
        });

        $this->app->extend('migration.creator', function (): MigrationCreator {
            return new ClasslessMigrationCreator(
                app('files'),
                app()->basePath('stubs'),
            );
        });

        $this->commands([
            MakeMigrationStubCommand::class,
        ]);
    }
}
