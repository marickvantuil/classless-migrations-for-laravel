<?php

declare(strict_types=1);

namespace Marick\LaravelClasslessMigrations;

use Illuminate\Database\Migrations\MigrationCreator;

class ClasslessMigrationCreator extends MigrationCreator
{
    protected function ensureMigrationDoesntAlreadyExist($name, $migrationPath = null)
    {
        // This function includes files to read their class name. This will cause existing
        // migrations to run if they are classless. Assuming that most projects already
        // use anonymous migrations, which can't be checked on existence anyway, we skip it.
    }
}
