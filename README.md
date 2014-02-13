# PHPUnit Headless

| Branch | Unit Tests | Coverage |
| ------ | ---------- | -------- |
| [![Latest Stable Version](https://poser.pugx.org/jakoch/phpunit-headless/v/stable.png)](https://packagist.org/packages/jakoch/phpunit-headless/) | [![Build Status](https://travis-ci.org/jakoch/phpunit-headless.png?branch=master)](https://travis-ci.org/jakoch/phpunit-headless/) | [![Code Coverage](https://scrutinizer-ci.com/g/jakoch/phpunit-headless/badges/coverage.png?s=d5f1f3d8d60acface9af5703812a1b7824fcce7c)](https://scrutinizer-ci.com/g/jakoch/phpunit-headless/) |

PHPUnit Headless is a PHPUnit extension which provides wrappers to PhantomJS and SlimerJS.

## Information

PhantomJS is a headless browser running on WebKit as used by Google/Safari.
It is not a test framework. Here tests are launched via PHPUnit as the test runner.
It runs purely headless (no X11) on Linux and is ideal for continuous integration systems.

SlimerJS is a (not yet fully) headless browser helper running on XulRunner as used by Gecko/Firefox.

Firefox -> PhantomJS + CasperJS + jQuery

Google  -> SlimerJS  + CasperJS + jQuery

## Requirements

* PHPUnit 3.7.*
* PhantomJS 1.9.*

## Installation via Composer

Please use [Composer](http://getcomposer.org/) to download and install PHPUnit Headless as well as all of its dependencies.
To add PHPUnit Headless as a local, per-project dependency to your project,
you simply add the following line to your project's `composer.json` file.

    {
        "require": {
            "jakoch/phpunit-headless": "dev-master"
        }
    }

## License

* BSD 3-Clause License - http://www.opensource.org/licenses/BSD-3-Clause
