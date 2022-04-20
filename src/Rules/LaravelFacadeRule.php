<?php

declare(strict_types=1);

/**
 * This file is part of the WterBerg/PHPStan-Laravel package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

namespace WterBerg\PHPStanLaravel\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * Class LaravelFacadeRule.
 *
 * Custom PHPStan rule for Laravel projects that scans for usages of the core Laravel facade for
 * which helper functions are available. As the Laravel helper functions lead to a smaller stack,
 * they are almost by definition more efficient and faster. The below example illustrates this by
 * comparing the Config facade versus its helper function equivalent.
 *
 * <strong>Callstack for `Config::get('app.name')`</strong>
 * <ol>
 *  <li>Config::get('app.name')</li>
 *  <li>Facade::__callStatic()</li>
 *  <li>static::getFacadeRoot</li>
 *  <li>static::resolveFacadeInstance(static::getFacadeAccessor())</li>
 *  <li>Container->offsetGet('config')</li>
 *  <li>Container->make('config')</li>
 *  <li><i>internals of make omitted as its identical for both scenarios</i></li>
 *  <li>get('app.name')</li>
 * </ol>
 *
 * <strong>Callstack for `config('app.name')`</strong>
 * <ol>
 *  <li>config('app.name')</li>
 *  <li>app('config')</li>
 *  <li>Container::getInstance()</li>
 *  <li>Container->make('config')</li>
 *  <li><i>internals of make omitted as its identical for both scenarios</i></li>
 *  <li>get('app.name')</li>
 * </ol>
 *
 * @implements Rule<StaticCall>
 */
class LaravelFacadeRule implements Rule
{
    /**
     * The facade/method combinations that this rule should scan for.
     *
     * @var array<string, array<string, mixed>>
     */
    private array $facades = [
        \Illuminate\Support\Facades\App::class    => [
            'alternative' => 'app()',
            'methods'     => ['make', 'makeWith'],
        ],
        \Illuminate\Support\Facades\Auth::class   => [
            'alternative' => 'auth()',
            'methods'     => ['guard'],
        ],
        \Illuminate\Support\Facades\Cache::class  => [
            'alternative' => 'cache()',
            'methods'     => ['get', 'put'],
        ],
        \Illuminate\Support\Facades\Config::class => [
            'alternative' => 'config()',
            'methods'     => ['get', 'set'],
        ],
        \Illuminate\Support\Facades\Redirect::class => [
            'alternative' => 'redirect()',
            'methods'     => ['to'],
        ],
        \Illuminate\Support\Facades\Request::class => [
            'alternative' => 'request()',
            'methods'     => ['only'],
        ],
        \Illuminate\Support\Facades\Session::class => [
            'alternative' => 'session()',
            'methods'     => ['get', 'put'],
        ],
        \Illuminate\Support\Facades\URL::class => [
            'alternative' => 'url()',
            'methods'     => ['to'],
        ],
        \Illuminate\Support\Facades\Validator::class => [
            'alternative' => 'validator()',
            'methods'     => ['make'],
        ],
        \Illuminate\Support\Facades\View::class => [
            'alternative' => 'view()',
            'methods'     => ['make'],
        ],
    ];

    /**
     * LaravelFacadeRule constructor.
     *
     * @param array<string, array<string, mixed>> $facades When non-empty, will override the
     *                                                     facade/method combinations that this rule
     *                                                     should target
     */
    public function __construct(array $facades = [])
    {
        if (!empty($facades)) {
            $this->facades = $facades;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getNodeType(): string
    {
        return \PhpParser\Node\Expr\StaticCall::class;
    }

    /**
     * {@inheritdoc}
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (!$node instanceof StaticCall) {
            return [];
        }

        if (!$node->class instanceof Name) {
            return [];
        }

        if (!$node->name instanceof Identifier) {
            return [];
        }

        $className  = $node->class->toString();
        $methodName = $node->name->toString();

        foreach ($this->facades as $facade => $config) {
            if ($className !== $facade) {
                continue;
            }

            if (!in_array($methodName, $config['methods'])) {
                continue;
            }

            return [
                RuleErrorBuilder::message(sprintf(
                    'Usage of Laravel %s::%s is discouraged; consider using %s instead.',
                    $facade,
                    $methodName,
                    $config['alternative']
                ))->build(),
            ];
        }

        return [];
    }
}
