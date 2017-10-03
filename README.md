# Yii2 MFA

**Multi-factor authentication for Yii2 projects**

[![Latest Stable Version](https://poser.pugx.org/hiqdev/yii2-mfa/v/stable)](https://packagist.org/packages/hiqdev/yii2-mfa)
[![Total Downloads](https://poser.pugx.org/hiqdev/yii2-mfa/downloads)](https://packagist.org/packages/hiqdev/yii2-mfa)
[![Build Status](https://img.shields.io/travis/hiqdev/yii2-mfa.svg)](https://travis-ci.org/hiqdev/yii2-mfa)
[![Scrutinizer Code Coverage](https://img.shields.io/scrutinizer/coverage/g/hiqdev/yii2-mfa.svg)](https://scrutinizer-ci.com/g/hiqdev/yii2-mfa/)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/hiqdev/yii2-mfa.svg)](https://scrutinizer-ci.com/g/hiqdev/yii2-mfa/)
[![Dependency Status](https://www.versioneye.com/php/hiqdev:yii2-mfa/dev-master/badge.svg)](https://www.versioneye.com/php/hiqdev:yii2-mfa/dev-master)

This package provides:

- [TOTP] - Time-based One-time Password Algorithm used for two factor authentication
- checking for user allowed IPs
- generation and checking recovery codes (PLANNED)

Uses:

- [robthree/twofactorauth] for TOTP
- [hiqdev/php-confirmator] for confirmation tokens

Can be plugged into any exising Yii2 project.
See how it is used in [hiqdev/hiam].

[TOTP]:                     https://en.wikipedia.org/wiki/Time-based_One-time_Password_Algorithm
[robthree/twofactorauth]:   https://github.com/robthree/twofactorauth
[hiqdev/php-confirmator]:   https://github.com/hiqdev/php-confirmator
[hiqdev/hiam]:              https://github.com/hiqdev/hiam

## Installation

The preferred way to install this yii2-extension is through [composer](http://getcomposer.org/download/).

Either run

```sh
php composer.phar require "hiqdev/yii2-mfa"
```

or add

```json
"hiqdev/yii2-mfa": "*"
```

to the require section of your composer.json.

## Configuration

This extension provides pluggable configuration to be used with [composer-config-plugin].

Also you can use it usual way by copy-pasting config.
See [src/config/web.php] for configuration example.

Available configuration parameters:

- `organization.name`

For more details please see [src/config/params.php].

[composer-config-plugin]:   https://github.com/hiqdev/composer-config-plugin
[src/config/params.php]:    src/config/params.php
[src/config/web.php]:       src/config/web.php

## Usage

This plugin provides behavior and configuration attaches it
to user component on beforeLogin` event.
And then the behavior validates IPs and TOTP on every login.

To use this plugin you need to provide:

- `allowed_ips` readable and writable property in your **user** component for allowed IPs functionality
- `totp_secret` readable and writable property in your **user** component for TOTP functionality

IPs and TOTP functions are independent and you can provide just one of properties to have only
corresponding functionality.

## License

This project is released under the terms of the BSD-3-Clause [license](LICENSE).
Read more [here](http://choosealicense.com/licenses/bsd-3-clause).

Copyright © 2016-2017, HiQDev (http://hiqdev.com/)
