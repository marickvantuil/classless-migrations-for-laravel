<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\Test;

class PackageTest extends TestCase
{
    #[Test]
    public function it_can_run_classless_migrations(): void
    {
        Artisan::call('migrate');

        $this->assertTrue(Schema::hasTable('posts'));
    }

    #[Test]
    public function it_can_still_run_anonymous_migrations(): void
    {
        Artisan::call('migrate');

        $this->assertTrue(Schema::hasTable('companies'));
    }

    #[Test]
    public function it_can_pretend_running_classless_migrations(): void
    {
        Artisan::call('migrate --pretend');

        $output = Artisan::output();

        $this->assertStringContainsString('2024_09_01_140000_create_posts_table', $output);
        $this->assertStringContainsString('create table "posts"', $output);
        $this->assertStringContainsString('2024_09_01_140000_create_companies_table', $output);
        $this->assertStringContainsString('create table "companies"', $output);
        $this->assertFalse(Schema::hasTable('posts'));
        $this->assertFalse(Schema::hasTable('companies'));
    }

    #[Test]
    public function rollback_will_not_rollback_classless_migrations(): void
    {
        Artisan::call('migrate');
        Artisan::call('migrate:rollback');

        $this->assertTrue(Schema::hasTable('posts'));
        $this->assertFalse(Schema::hasTable('companies'));
    }

    #[Test]
    public function it_can_dump_schema(): void
    {
        Artisan::call('migrate');
        Artisan::call('schema:dump');

        $this->assertTrue(file_exists(database_path('schema/sqlite-schema.sql')));

        $contents = file_get_contents(database_path('schema/sqlite-schema.sql'));

        $this->assertStringContainsString('2024_09_01_140000_create_posts_table', $contents);
        $this->assertStringContainsString('CREATE TABLE IF NOT EXISTS "posts"', $contents);
        $this->assertStringContainsString('2024_09_01_140000_create_companies_table', $contents);
        $this->assertStringContainsString('CREATE TABLE IF NOT EXISTS "companies"', $contents);
        $this->assertTrue(Schema::hasTable('posts'));
        $this->assertTrue(Schema::hasTable('companies'));
    }

    #[Test]
    public function it_has_a_command_to_create_a_custom_skeleton(): void
    {
        Artisan::call('classless-migrations:make-stub');

        $this->assertTrue(file_exists(base_path('stubs/migration.create.stub')));
        $this->assertTrue(file_exists(base_path('stubs/migration.stub')));
        $this->assertTrue(file_exists(base_path('stubs/migration.update.stub')));
    }
}
