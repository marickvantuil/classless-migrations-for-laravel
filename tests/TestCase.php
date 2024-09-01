<?php

declare(strict_types=1);

namespace Tests;

use Marick\LaravelClasslessMigrations\ClasslessMigrationsServiceProvider;
use Orchestra\Testbench\Concerns\WithWorkbench;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use WithWorkbench;

    protected function defineEnvironment($app)
    {
        @unlink(database_path('database.sqlite'));
        @touch(database_path('database.sqlite'));
        @unlink(database_path('schema/sqlite-schema.sql'));
        @unlink(base_path('stubs/migration.create.stub'));
        @unlink(base_path('stubs/migration.stub'));
        @unlink(base_path('stubs/migration.update.stub'));

        foreach (glob(database_path('migrations/*.php')) as $file) {
            @unlink($file);
        }

        $app['config']->set('database.connections.testing.database', database_path('database.sqlite'));
    }

    protected function getPackageProviders($app): array
    {
        return [
            ClasslessMigrationsServiceProvider::class,
        ];
    }
}
