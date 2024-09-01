<?php

declare(strict_types=1);

namespace Marick\LaravelClasslessMigrations;

use const T_CLASS;
use const T_NEW;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Migrations\Migrator;

use function Safe\file_get_contents;

class ClasslessMigrator extends Migrator
{
    public function requireFiles(array $files)
    {
        //
    }

    public function getMigrationName($path): string
    {
        if (debug_backtrace(limit: 2)[1]['function'] ?? '' === 'pretendToRun') {
            $runUp = collect(debug_backtrace(limit: 5))->firstWhere('function', 'runUp');

            if ($runUp) {
                $path = head($runUp['args']);
            }
        }

        return parent::getMigrationName($path);
    }

    protected function resolvePath(string $path): object
    {
        if (! $this->isClassless($path)) {
            return parent::resolvePath($path);
        }

        return new class($path) extends Migration
        {
            public function __construct(private readonly string $migrationPath)
            {
                //
            }

            public function up(): void
            {
                include $this->migrationPath;
            }
        };
    }

    private function isClassless(string $path): bool
    {
        $code = file_get_contents($path);

        // If it contains "new class", then it's either an anonymous class
        // "return new class { ... }" or it's an older migration like
        // "new class CreateUsersTable { ... }"
        return ! Tokens::from($code)->contains(T_NEW.T_CLASS);
    }
}
