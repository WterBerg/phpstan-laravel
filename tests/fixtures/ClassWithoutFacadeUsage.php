<?php

declare(strict_types=1);

/**
 * This file is part of the wterberg/phpstan-laravel package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

namespace Tests\fixtures;

use DateTime;

final class ClassWithoutFacadeUsage
{
    public DateTime $property;

    public function __construct()
    {
        $this->property = DateTime::createFromFormat('Y', 'now');
    }
}
