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
use WterBerg\PHPStanLaravel\Rules\LaravelEnvFunctionCallsRule;

/**
 * @internal
 * @coversDefaultClass \WterBerg\PHPStanLaravel\Rules\LaravelEnvFunctionCallsRule
 */
class LaravelEnvFunctionCallsRuleTest extends TestCase
{
    /**
     * @covers ::getNodeType
     */
    public function testRuleOnlyFiresOnStaticCalls(): void
    {
        $facadeRule = new LaravelEnvFunctionCallsRule();

        $this->assertEquals(\PhpParser\Node\Expr\FuncCall::class, $facadeRule->getNodeType());
    }

    /**
     * @covers ::processNode
     */
    public function testProcessingHaltsWhenNonFuncCallInstanceIsPassed(): void
    {
        $facadeRule = new LaravelEnvFunctionCallsRule();
        $nodeMock   = Mockery::mock(\PhpParser\Node\Expr\MethodCall::class);
        $scopeMock  = Mockery::mock(\PHPStan\Analyser\Scope::class);

        $this->assertCount(0, $facadeRule->processNode($nodeMock, $scopeMock));
    }

    /**
     * @covers ::processNode
     */
    public function testProcessingHaltsWhenNameIsAnExpression(): void
    {
        $facadeRule = new LaravelEnvFunctionCallsRule();
        $nodeMock   = Mockery::mock(\PhpParser\Node\Expr\FuncCall::class);
        $nameMock   = Mockery::mock(\PhpParser\Node\Expr::class);
        $scopeMock  = Mockery::mock(\PHPStan\Analyser\Scope::class);

        $nodeMock->name = $nameMock;

        $this->assertCount(0, $facadeRule->processNode($nodeMock, $scopeMock));
    }

    /**
     * @covers ::processNode
     */
    public function testProcessingHaltsWhenMethodsDoNotMatch(): void
    {
        $facadeRule = new LaravelEnvFunctionCallsRule();
        $nodeMock   = Mockery::mock(\PhpParser\Node\Expr\FuncCall::class);
        $nameMock   = Mockery::mock(\PhpParser\Node\Name::class);
        $scopeMock  = Mockery::mock(\PHPStan\Analyser\Scope::class);

        $nameMock->shouldReceive('toString')
            ->andReturn('notEnv');

        $nodeMock->name = $nameMock;

        $this->assertCount(0, $facadeRule->processNode($nodeMock, $scopeMock));
    }

    /**
     * @covers ::processNode
     */
    public function testEnvCallsAreValidWhenConfigIsPresentInThePath(): void
    {
        $facadeRule = new LaravelEnvFunctionCallsRule();
        $nodeMock   = Mockery::mock(\PhpParser\Node\Expr\FuncCall::class);
        $nameMock   = Mockery::mock(\PhpParser\Node\Name::class);

        $nameMock->shouldReceive('toString')
            ->andReturn('env');

        $nodeMock->name = $nameMock;

        $scopeMock = Mockery::mock(\PHPStan\Analyser\Scope::class);
        $scopeMock->shouldReceive('getFile')
            ->andReturn('/foo/bar/config/file.php');

        $this->assertCount(0, $facadeRule->processNode($nodeMock, $scopeMock));
    }

    /**
     * @covers ::processNode
     */
    public function testEnvCallsAreInvalidWhenConfigIsNotPresentInThePath(): void
    {
        $facadeRule = new LaravelEnvFunctionCallsRule();
        $nodeMock   = Mockery::mock(\PhpParser\Node\Expr\FuncCall::class);
        $nameMock   = Mockery::mock(\PhpParser\Node\Name::class);

        $nameMock->shouldReceive('toString')
            ->andReturn('env');

        $nodeMock->name = $nameMock;

        $scopeMock = Mockery::mock(\PHPStan\Analyser\Scope::class);
        $scopeMock->shouldReceive('getFile')
            ->andReturn('/foo/bar/file.php');

        $result = $facadeRule->processNode($nodeMock, $scopeMock);

        $this->assertCount(1, $result);
    }
}
