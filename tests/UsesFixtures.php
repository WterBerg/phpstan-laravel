<?php

declare(strict_types=1);

/**
 * This file is part of the wterberg/phpstan-laravel package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

namespace Tests;

trait UsesFixtures
{
    private function fixturePath(string $file): string
    {
        return __DIR__ . '/fixtures/' . $file;
    }
}
