<?php

declare(strict_types=1);

/**
 * This file is part of the wterberg/phpstan-laravel package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

namespace Tests\Unit\Rules;

use Mockery as M;
use Mockery\MockInterface as MI;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPUnit\Framework\TestCase;
use WterBerg\Laravel\PHPStan\Rules\LaravelFacadeRule;

/**
 * @internal
 */
final class LaravelFacadeRuleTest extends TestCase
{
    public function testRuleOnlyFiresOnStaticCalls(): void
    {
        self::assertEquals(
            StaticCall::class,
            (new LaravelFacadeRule())->getNodeType()
        );
    }

    public function testProcessingHaltsWhenNonStaticCallInstanceIsPassed(): void
    {
        self::assertCount(0, (new LaravelFacadeRule())->processNode(
            M::mock(MethodCall::class),
            M::mock(Scope::class)
        ));
    }

    public function testProcessingHaltsWhenClassIsAnExpression(): void
    {
        self::assertCount(0, (new LaravelFacadeRule())->processNode(
            M::mock(StaticCall::class, function(MI $mock) {
                $mock->class = M::mock(Expr::class);
            }),
            M::mock(Scope::class)
        ));
    }

    public function testProcessingHaltsWhenNameIsAnExpression(): void
    {
        self::assertCount(0, (new LaravelFacadeRule())->processNode(
            M::mock(StaticCall::class, function(MI $mock) {
                $mock->class = M::mock(Name::class);
                $mock->name  = M::mock(Expr::class);
            }),
            M::mock(Scope::class)
        ));
    }

    public function testProcessingHaltsWhenMethodsDoNotMatch(): void
    {
        $facadeRule = new LaravelFacadeRule(['Foo' => [
            'alternative' => 'bar()',
            'methods'     => ['lorem'],
        ]]);

        self::assertCount(0, $facadeRule->processNode(
            M::mock(StaticCall::class, function(MI $mock) {
                $mock->class = M::mock(Name::class, function(MI $mock) {
                    $mock->shouldReceive('toString')->andReturn('Foo');
                });

                $mock->name = M::mock(Name::class, function(MI $mock) {
                    $mock->shouldReceive('toString')->andReturn('MockedName');
                });
            }),
            M::mock(Scope::class)
        ));
    }
}
