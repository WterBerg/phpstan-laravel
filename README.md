# WterBerg / PHPStan-Laravel

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![GitHub issues](https://img.shields.io/github/issues/WterBerg/phpstan-laravel)](https://github.com/WterBerg/phpstan-laravel/issues)

[github.com/wterberg/dcat-catalog](https://github.com/wterberg/dcat-catalog.git)

Contains several custom rules to analyse Laravel projects with PHPStan.

## License

View the `LICENSE.md` file for licensing details.

## Installation

Installation of [`wterberg/phpstan-laravel`](https://packagist.org/packages/wterberg/phpstan-laravel) is done via [Composer](https://getcomposer.org).

```shell
composer require --dev wterberg/phpstan-laravel
```

## Usage

To start using the custom PHPStan rules, simply include the below snippet in the `phpstan.neon` or `phpstan.neon.dist` file of your project. 

```yaml
includes:
    - ./vendor/wterberg/phpstan-laravel/extension.neon
```
