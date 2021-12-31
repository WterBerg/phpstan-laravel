<?php

declare(strict_types=1);

/**
 * This file is part of the WterBerg/PHPStan-Laravel package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

namespace Tests;

use Illuminate\Support\Facades\Config;

class ClassUsingConfigFacade
{
    public $property;

    public function __construct()
    {
        Config::set('foo.bar', 'lorem ipsum');

        $this->property = Config::get('foo.bar');
    }
}
