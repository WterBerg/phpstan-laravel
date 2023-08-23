<?php

declare(strict_types=1);

/**
 * This file is part of the wterberg/phpstan-laravel package.
 *
 * This source file is subject to the license that is
 * bundled with this source code in the LICENSE.md file.
 */

include 'vendor/autoload.php';

$package = Composer\InstalledVersions::getRootPackage()['name'];
$rules   = include \XpertSelect\Tools\ProjectType::Standard->phpCsFixerRuleFile();

$rules['header_comment']['header'] = trim('
This file is part of the ' . $package . ' package.

This source file is subject to the license that is
bundled with this source code in the LICENSE.md file.
');

$finder = PhpCsFixer\Finder::create()
    ->in([__DIR__])
    ->append([__FILE__])
    ->ignoreDotFiles(false)
    ->ignoreVCSIgnored(true);

return (new PhpCsFixer\Config('XpertSelect/Laravel'))
    ->setIndent('    ')
    ->setLineEnding("\n")
    ->setRules($rules)
    ->setFinder($finder);
