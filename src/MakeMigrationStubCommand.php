<?php

declare(strict_types=1);

namespace Marick\LaravelClasslessMigrations;

use Illuminate\Console\Command;

use function Safe\copy;

class MakeMigrationStubCommand extends Command
{
    protected $name = 'classless-migrations:make-stub';

    public function handle(): int
    {
        $stubs = [
            'migration.create',
            'migration',
            'migration.update',
        ];

        if (! file_exists(base_path('stubs'))) {
            mkdir(base_path('stubs'));
        }

        foreach ($stubs as $stub) {
            copy(
                from: __DIR__.'/../stubs/'.$stub.'.stub',
                to: base_path('stubs/'.$stub.'.stub')
            );
        }

        return 0;
    }
}
