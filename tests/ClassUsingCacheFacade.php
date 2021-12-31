<?php

declare(strict_types=1);

/**
 * This file is part of the WterBerg/PHPStan-Laravel package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

namespace Tests;

use Illuminate\Support\Facades\Cache;

class ClassUsingCacheFacade
{
    public $property;

    public function __construct()
    {
        Cache::forever('foo.bar', 'lorem ipsum');
        Cache::put('foo.bar', 'lorem ipsum', 100);

        $this->property = Cache::get('foo.bar');
    }
}
