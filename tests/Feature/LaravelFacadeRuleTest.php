<?php

declare(strict_types=1);

/**
 * This file is part of the WterBerg/PHPStan-Laravel package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

namespace Tests\Feature;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use WterBerg\PHPStanLaravel\Rules\LaravelFacadeRule;

/**
 * @internal
 */
class LaravelFacadeRuleTest extends RuleTestCase
{
    /**
     * @var array<string, array<int, array<int, string|int>>>
     */
    private array $testCases = [
        __DIR__ . '/../ClassWithoutFacadeUsage.php' => [],
        __DIR__ . '/../ClassUsingConfigFacade.php'  => [
            [
                'Usage of Laravel Illuminate\Support\Facades\Config::set is discouraged; consider using config() instead.',
                22,
            ], [
                'Usage of Laravel Illuminate\Support\Facades\Config::get is discouraged; consider using config() instead.',
                24,
            ],
        ],
        __DIR__ . '/../ClassUsingCacheFacade.php' => [
            [
                'Usage of Laravel Illuminate\Support\Facades\Cache::put is discouraged; consider using cache() instead.',
                23,
            ], [
                'Usage of Laravel Illuminate\Support\Facades\Cache::get is discouraged; consider using cache() instead.',
                25,
            ],
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function testRule(): void
    {
        foreach ($this->testCases as $testFile => $errors) {
            $this->analyse([$testFile], $errors);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function getRule(): Rule
    {
        return new LaravelFacadeRule();
    }
}
