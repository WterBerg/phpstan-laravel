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
use WterBerg\Laravel\PHPStan\Rules\LaravelFacadeRule;

/**
 * @internal
 */
final class LaravelFacadeRuleTest extends TestCase
{
    public function testRuleOnlyFiresOnStaticCalls(): void
    {
        $this->assertEquals(
            \PhpParser\Node\Expr\StaticCall::class,
            (new LaravelFacadeRule())->getNodeType()
        );
    }

    public function testProcessingHaltsWhenNonStaticCallInstanceIsPassed(): void
    {
        $this->assertCount(0, (new LaravelFacadeRule())->processNode(
            M::mock(\PhpParser\Node\Expr\MethodCall::class),
            M::mock(\PHPStan\Analyser\Scope::class)
        ));
    }

    public function testProcessingHaltsWhenClassIsAnExpression(): void
    {
        $this->assertCount(0, (new LaravelFacadeRule())->processNode(
            M::mock(\PhpParser\Node\Expr\StaticCall::class, function(MI $mock) {
                $mock->class = M::mock(\PhpParser\Node\Expr::class);
            }),
            M::mock(\PHPStan\Analyser\Scope::class)
        ));
    }

    public function testProcessingHaltsWhenNameIsAnExpression(): void
    {
        $this->assertCount(0, (new LaravelFacadeRule())->processNode(
            M::mock(\PhpParser\Node\Expr\StaticCall::class, function(MI $mock) {
                $mock->class = M::mock(\PhpParser\Node\Name::class);
                $mock->name  = M::mock(\PhpParser\Node\Expr::class);
            }),
            M::mock(\PHPStan\Analyser\Scope::class)
        ));
    }

    public function testProcessingHaltsWhenMethodsDoNotMatch(): void
    {
        $facadeRule = new LaravelFacadeRule(['Foo' => [
            'alternative' => 'bar()',
            'methods'     => ['lorem'],
        ]]);

        $this->assertCount(0, $facadeRule->processNode(
            M::mock(\PhpParser\Node\Expr\StaticCall::class, function(MI $mock) {
                $mock->class = M::mock(\PhpParser\Node\Name::class, function(MI $mock) {
                    $mock->shouldReceive('toString')->andReturn('Foo');
                });

                $mock->name = M::mock(\PhpParser\Node\Name::class, function(MI $mock) {
                    $mock->shouldReceive('toString')->andReturn('MockedName');
                });
            }),
            M::mock(\PHPStan\Analyser\Scope::class)
        ));
    }
}
