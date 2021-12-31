<?php

declare(strict_types=1);

/**
 * This file is part of the WterBerg/PHPStan-Laravel package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

namespace Tests\Unit\Rules;

use Mockery;
use PHPUnit\Framework\TestCase;
use WterBerg\PHPStanLaravel\Rules\LaravelFacadeRule;

/**
 * @internal
 * @coversDefaultClass \WterBerg\PHPStanLaravel\Rules\LaravelFacadeRule
 */
class LaravelFacadeRuleTest extends TestCase
{
    /**
     * @covers ::getNodeType
     */
    public function testRuleOnlyFiresOnStaticCalls(): void
    {
        $facadeRule = new LaravelFacadeRule();

        $this->assertEquals(\PhpParser\Node\Expr\StaticCall::class, $facadeRule->getNodeType());
    }

    /**
     * @covers ::processNode
     */
    public function testProcessingHaltsWhenNonStaticCallInstanceIsPassed(): void
    {
        $facadeRule = new LaravelFacadeRule();
        $nodeMock   = Mockery::mock(\PhpParser\Node\Expr\MethodCall::class);
        $scopeMock  = Mockery::mock(\PHPStan\Analyser\Scope::class);

        $this->assertCount(0, $facadeRule->processNode($nodeMock, $scopeMock));
    }

    /**
     * @covers ::processNode
     */
    public function testProcessingHaltsWhenClassIsAnExpression(): void
    {
        $facadeRule = new LaravelFacadeRule();
        $nodeMock   = Mockery::mock(\PhpParser\Node\Expr\StaticCall::class);
        $classMock  = Mockery::mock(\PhpParser\Node\Expr::class);
        $scopeMock  = Mockery::mock(\PHPStan\Analyser\Scope::class);

        $nodeMock->class = $classMock;

        $this->assertCount(0, $facadeRule->processNode($nodeMock, $scopeMock));
    }

    /**
     * @covers ::processNode
     */
    public function testProcessingHaltsWhenNameIsAnExpression(): void
    {
        $facadeRule = new LaravelFacadeRule();
        $nodeMock   = Mockery::mock(\PhpParser\Node\Expr\StaticCall::class);
        $classMock  = Mockery::mock(\PhpParser\Node\Name::class);
        $nameMock   = Mockery::mock(\PhpParser\Node\Expr::class);
        $scopeMock  = Mockery::mock(\PHPStan\Analyser\Scope::class);

        $nodeMock->class = $classMock;
        $nodeMock->name  = $nameMock;

        $this->assertCount(0, $facadeRule->processNode($nodeMock, $scopeMock));
    }

    /**
     * @covers ::__construct
     * @covers ::processNode
     */
    public function testProcessingHaltsWhenMethodsDoNotMatch(): void
    {
        $facadeRule = new LaravelFacadeRule([
            'Foo' => [
                'alternative' => 'bar()',
                'methods'     => ['lorem'],
            ],
        ]);
        $nodeMock   = Mockery::mock(\PhpParser\Node\Expr\StaticCall::class);
        $classMock  = Mockery::mock(\PhpParser\Node\Name::class);
        $nameMock   = Mockery::mock(\PhpParser\Node\Name::class);
        $scopeMock  = Mockery::mock(\PHPStan\Analyser\Scope::class);

        $classMock->shouldReceive('toString')
            ->andReturn('Foo');
        $nameMock->shouldReceive('toString')
            ->andReturn('MockedName');

        $nodeMock->class = $classMock;
        $nodeMock->name  = $nameMock;

        $this->assertCount(0, $facadeRule->processNode($nodeMock, $scopeMock));
    }
}
