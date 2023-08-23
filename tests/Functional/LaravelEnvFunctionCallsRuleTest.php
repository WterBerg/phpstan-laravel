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
use WterBerg\Laravel\PHPStan\Rules\LaravelEnvFunctionCallsRule;

/**
 * @internal
 */
final class LaravelEnvFunctionCallsRuleTest extends RuleTestCase
{
    use UsesFixtures;

    /**
     * @var array<string, array<int, array<int, string|int>>>
     */
    private array $testCases = [
        'ClassWithoutEnvFunctionCall.php' => [],
        'ClassWithEnvFunctionCall.php'    => [[
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
        foreach ($this->testCases as $file => $expectedErrors) {
            $this->analyse([$this->fixturePath($file)], $expectedErrors);
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
