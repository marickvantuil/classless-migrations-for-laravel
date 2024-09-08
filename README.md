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

# Installation

```shell
composer require marick/classless-migrations-for-laravel
```

That's all. You may now write classless migrations.

