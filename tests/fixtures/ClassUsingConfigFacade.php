<?php

declare(strict_types=1);

/**
 * This file is part of the wterberg/phpstan-laravel package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

namespace Tests\fixtures;

use Illuminate\Support\Facades\Config;

final class ClassUsingConfigFacade
{
    public $property;

    public function __construct()
    {
        Config::set('foo.bar', 'lorem ipsum');

        $this->property = Config::get('foo.bar');
    }
}
