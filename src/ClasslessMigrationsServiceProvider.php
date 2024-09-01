<?php

declare(strict_types=1);

namespace Marick\LaravelClasslessMigrations;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ClasslessMigrationsServiceProvider extends LaravelServiceProvider
{
    public function register(): void
    {
        $this->app->extend('migrator', function (): ClasslessMigrator {
            $repository = app('migration.repository');

            return new ClasslessMigrator(
                $repository,
                app('db'),
                app('files'),
                app('events')
            );
        });

        $this->commands([
            MakeMigrationStubCommand::class,
        ]);
    }
}
