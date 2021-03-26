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
to user component on `beforeLogin` event.
And then the behavior validates IPs and TOTP on every login.

To use this plugin you have to instantiate your `\Yii->app->user->identity` class from
`hiqdev\yii2\mfa\base\MfaIdentityInterface` and implement all of the methods,
which will return or set MFA properties. For example:

    use hiqdev\yii2\mfa\base\MfaIdentityInterface;

    class Identity implements MfaIdentityInterface
    {
        ...

        /**
         * @inheritDoc
         */
        public function getUsername(): string
        {
            return $this->username;
        }

        /**
         * @inheritDoc
         */
        public function getTotpSecret(): string
        {
            return $this->totp_secret ?? '';
        }

        ...

IPs and TOTP functions are independent and you can provide just one of properties to have only
corresponding functionality.

## Usage with OAuth2

Also there is a configuration to provide MFA for OAuth2.

 - Require suggested `"bshaffer/oauth2-server-php": '~1.7'` package

 - Use `hiqdev\yii2\mfa\GrantType\UserCredentials` for configuring `/oauth/token` command via totp code.
For example:


    'modules' => [
        'oauth2' => [
            'grantTypes' => [
                'user_credentials' => [
                    'class' => \hiqdev\yii2\mfa\GrantType\UserCredentials::class,
                ],
            ],
        ],
    ]

 - Extend you `Identity` class from `ApiMfaIdentityInterface`.

 - Use actions:


    POST /mfa/totp/api-temporary-secret - Proviedes temporary secret to generate QR-code
    POST /mfa/totp/api-enable - Enables totp
    POST /mfa/totp/api-disable - Disables totp

## License

This project is released under the terms of the BSD-3-Clause [license](LICENSE).
Read more [here](http://choosealicense.com/licenses/bsd-3-clause).

Copyright © 2016-2018, HiQDev (http://hiqdev.com/)
