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
use WterBerg\PHPStanLaravel\Rules\LaravelEnvFunctionCallsRule;

/**
 * @internal
 */
class LaravelEnvFunctionCallsRuleTest extends RuleTestCase
{
    /**
     * @var array<string, array<int, array<int, string|int>>>
     */
    private array $testCases = [
        __DIR__ . '/../ClassWithoutEnvFunctionCall.php' => [],
        __DIR__ . '/../ClassWithEnvFunctionCall.php'    => [[
            'Usage of the env() function outside the config/ directory is discouraged as it may have unexpected results when using \'php artisan config:cache\'.
    💡 See: https://laravel.com/docs/master/configuration#configuration-caching',
            20,
        ]],
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
        return new LaravelEnvFunctionCallsRule();
    }
}
