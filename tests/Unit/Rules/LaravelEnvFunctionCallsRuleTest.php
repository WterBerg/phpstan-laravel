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
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPUnit\Framework\TestCase;
use WterBerg\Laravel\PHPStan\Rules\LaravelEnvFunctionCallsRule;

/**
 * @internal
 */
final class LaravelEnvFunctionCallsRuleTest extends TestCase
{
    public function testRuleOnlyFiresOnStaticCalls(): void
    {
        self::assertEquals(
            FuncCall::class,
            (new LaravelEnvFunctionCallsRule())->getNodeType()
        );
    }

    public function testProcessingHaltsWhenNonFuncCallInstanceIsPassed(): void
    {
        self::assertCount(0, (new LaravelEnvFunctionCallsRule())->processNode(
            M::mock(MethodCall::class),
            M::mock(Scope::class)
        ));
    }

    public function testProcessingHaltsWhenNameIsAnExpression(): void
    {
        self::assertCount(0, (new LaravelEnvFunctionCallsRule())->processNode(
            M::mock(FuncCall::class, function(MI $mock) {
                $mock->name = M::mock(Expr::class);
            }),
            M::mock(Scope::class)
        ));
    }

    public function testProcessingHaltsWhenMethodsDoNotMatch(): void
    {
        self::assertCount(0, (new LaravelEnvFunctionCallsRule())->processNode(
            M::mock(FuncCall::class, function(MI $mock) {
                $mock->name = M::mock(Name::class, function(MI $mock) {
                    $mock->shouldReceive('toString')->andReturn('notEnv');
                });
            }),
            M::mock(Scope::class)
        ));
    }

    public function testEnvCallsAreValidWhenConfigIsPresentInThePath(): void
    {
        self::assertCount(0, (new LaravelEnvFunctionCallsRule())->processNode(
            M::mock(FuncCall::class, function(MI $mock) {
                $mock->name = M::mock(Name::class, function(MI $mock) {
                    $mock->shouldReceive('toString')->andReturn('env');
                });
            }),
            M::mock(Scope::class, function(MI $mock) {
                $mock->shouldReceive('getFile')->andReturn('/foo/bar/config/file.php');
            })
        ));
    }

    public function testEnvCallsAreInvalidWhenConfigIsNotPresentInThePath(): void
    {
        self::assertCount(1, (new LaravelEnvFunctionCallsRule())->processNode(
            M::mock(FuncCall::class, function(MI $mock) {
                $mock->name = M::mock(Name::class, function(MI $mock) {
                    $mock->shouldReceive('toString')->andReturn('env');
                });
            }),
            M::mock(Scope::class, function(MI $mock) {
                $mock->shouldReceive('getFile')->andReturn('/foo/bar/file.php');
            })
        ));
    }
}
