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
use PHPUnit\Framework\TestCase;
use WterBerg\Laravel\PHPStan\Rules\LaravelEnvFunctionCallsRule;

/**
 * @internal
 */
final class LaravelEnvFunctionCallsRuleTest extends TestCase
{
    public function testRuleOnlyFiresOnStaticCalls(): void
    {
        $this->assertEquals(
            \PhpParser\Node\Expr\FuncCall::class,
            (new LaravelEnvFunctionCallsRule())->getNodeType()
        );
    }

    public function testProcessingHaltsWhenNonFuncCallInstanceIsPassed(): void
    {
        $this->assertCount(0, (new LaravelEnvFunctionCallsRule())->processNode(
            M::mock(\PhpParser\Node\Expr\MethodCall::class),
            M::mock(\PHPStan\Analyser\Scope::class)
        ));
    }

    public function testProcessingHaltsWhenNameIsAnExpression(): void
    {
        $this->assertCount(0, (new LaravelEnvFunctionCallsRule())->processNode(
            M::mock(\PhpParser\Node\Expr\FuncCall::class, function(MI $mock) {
                $mock->name = M::mock(\PhpParser\Node\Expr::class);
            }),
            M::mock(\PHPStan\Analyser\Scope::class)
        ));
    }

    public function testProcessingHaltsWhenMethodsDoNotMatch(): void
    {
        $this->assertCount(0, (new LaravelEnvFunctionCallsRule())->processNode(
            M::mock(\PhpParser\Node\Expr\FuncCall::class, function(MI $mock) {
                $mock->name = M::mock(\PhpParser\Node\Name::class, function(MI $mock) {
                    $mock->shouldReceive('toString')->andReturn('notEnv');
                });
            }),
            M::mock(\PHPStan\Analyser\Scope::class)
        ));
    }

    public function testEnvCallsAreValidWhenConfigIsPresentInThePath(): void
    {
        $this->assertCount(0, (new LaravelEnvFunctionCallsRule())->processNode(
            M::mock(\PhpParser\Node\Expr\FuncCall::class, function(MI $mock) {
                $mock->name = M::mock(\PhpParser\Node\Name::class, function(MI $mock) {
                    $mock->shouldReceive('toString')->andReturn('env');
                });
            }),
            M::mock(\PHPStan\Analyser\Scope::class, function(MI $mock) {
                $mock->shouldReceive('getFile')->andReturn('/foo/bar/config/file.php');
            })
        ));
    }

    public function testEnvCallsAreInvalidWhenConfigIsNotPresentInThePath(): void
    {
        $this->assertCount(1, (new LaravelEnvFunctionCallsRule())->processNode(
            M::mock(\PhpParser\Node\Expr\FuncCall::class, function(MI $mock) {
                $mock->name = M::mock(\PhpParser\Node\Name::class, function(MI $mock) {
                    $mock->shouldReceive('toString')->andReturn('env');
                });
            }),
            M::mock(\PHPStan\Analyser\Scope::class, function(MI $mock) {
                $mock->shouldReceive('getFile')->andReturn('/foo/bar/file.php');
            })
        ));
    }
}
