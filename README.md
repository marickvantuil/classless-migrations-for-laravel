# Introduction

This package allows you to create classless migrations that look like this:

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

Schema::create('posts', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->string('slug');
    $table->text('body');
    $table->boolean('published')->default(false);
    $table->timestamps();
    $table->softDeletes();
});
```

You might notice there's no way to roll back this migration. That's intentional. This package is for those daredevils
who are already skipping the `down()` method on their migrations. Now, you don't even have the option - it's
forward-only from here on out!

# Installation

```shell
composer require marick/classless-migrations-for-laravel
```

That's all. You may now write classless migrations.

## Publish migration stubs

```shell
php artisan classless-migrations:make-stub
```

Will publish the migration stubs so that `php artisan make:migration` creates classless migrations.

## Important questions

### Should I use this?

Maybe! Should you?

### Should my team or my company use this?

Probably not!
