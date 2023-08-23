<?php

declare(strict_types=1);

/**
 * This file is part of the wterberg/phpstan-laravel package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

namespace WterBerg\Laravel\PHPStan\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * Class LaravelEnvFunctionCallsRule.
 *
 * Custom PHPStan rule for Laravel projects that scans for any usage of the `env()` function outside
 * the `config/` directory. The `.env` file is ignored after using `php artisan config:cache`. This
 * may lead to unexpected results.
 *
 * @implements Rule<FuncCall>
 */
final class LaravelEnvFunctionCallsRule implements Rule
{
    /**
     * {@inheritdoc}
     */
    public function getNodeType(): string
    {
        return \PhpParser\Node\Expr\FuncCall::class;
    }

    /**
     * {@inheritdoc}
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (!$node instanceof FuncCall) {
            return [];
        }

        if (!$node->name instanceof Name) {
            return [];
        }

        if ($node->name->toString() !== 'env') {
            return [];
        }

        // TODO:
        // Figure out a better way to determine whether a file in the config/ directory is being
        // scanned. As the config/ directory itself can also contain directories, simply check
        // whether config is present as a directory in the path of the file being scanned.
        // Ideally, access to the Laravel `config_path()` function would lead to a more conclusive
        // scan.
        if (in_array('config', explode('/', dirname($scope->getFile())))) {
            return [];
        }

        return [
            RuleErrorBuilder::message(
                'Usage of the env() function outside the config/ directory is discouraged as it ' .
                'may have unexpected results when using \'php artisan config:cache\'.'
            )->tip('See: https://laravel.com/docs/master/configuration#configuration-caching')->build(),
        ];
    }
}
