<?php

declare(strict_types=1);

/**
 * This file is part of the wterberg/phpstan-laravel package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

namespace Tests\Functional;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use Tests\UsesFixtures;
use WterBerg\Laravel\PHPStan\Rules\LaravelFacadeRule;

/**
 * @internal
 */
final class LaravelFacadeRuleTest extends RuleTestCase
{
    use UsesFixtures;

    /**
     * @var array<string, array<int, array<int, string|int>>>
     */
    private array $testCases = [
        'ClassWithoutFacadeUsage.php' => [],
        'ClassUsingConfigFacade.php'  => [[
            'Usage of Laravel Illuminate\Support\Facades\Config::set is discouraged; consider using config() instead.',
            22,
        ], [
            'Usage of Laravel Illuminate\Support\Facades\Config::get is discouraged; consider using config() instead.',
            24,
        ]],
        'ClassUsingCacheFacade.php' => [[
            'Usage of Laravel Illuminate\Support\Facades\Cache::put is discouraged; consider using cache() instead.',
            23,
        ], [
            'Usage of Laravel Illuminate\Support\Facades\Cache::get is discouraged; consider using cache() instead.',
            25,
        ]],
    ];

    /**
     * {@inheritdoc}
     */
    public function testRule(): void
    {
        foreach ($this->testCases as $file => $expectedErrors) {
            $this->analyse([$this->fixturePath($file)], $expectedErrors);
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
