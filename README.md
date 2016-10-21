Yii2 MFA
========

**Yii2 module providing multi-factor authentication**

[![Latest Stable Version](https://poser.pugx.org/hiqdev/yii2-mfa/v/stable)](https://packagist.org/packages/hiqdev/yii2-mfa)
[![Total Downloads](https://poser.pugx.org/hiqdev/yii2-mfa/downloads)](https://packagist.org/packages/hiqdev/yii2-mfa)
[![Build Status](https://img.shields.io/travis/hiqdev/yii2-mfa.svg)](https://travis-ci.org/hiqdev/yii2-mfa)
[![Scrutinizer Code Coverage](https://img.shields.io/scrutinizer/coverage/g/hiqdev/yii2-mfa.svg)](https://scrutinizer-ci.com/g/hiqdev/yii2-mfa/)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/hiqdev/yii2-mfa.svg)](https://scrutinizer-ci.com/g/hiqdev/yii2-mfa/)
[![Dependency Status](https://www.versioneye.com/php/hiqdev:yii2-mfa/dev-master/badge.svg)](https://www.versioneye.com/php/hiqdev:yii2-mfa/dev-master)

This package provides:

- [TOTP](https://en.wikipedia.org/wiki/Time-based_One-time_Password_Algorithm) -
Time-based_One-time Password Algorithm used for two factor authentication.
- checking for user allowed IPs
- generation and checking recovery codes (PLANNED)

Uses:

- [robthree/twofactorauth](https://github.com/robthree/twofactorauth) for TOTP

Can be plugged to exising project.
See how it is used in [hiqdev/hiam-core](https://github.com/hiqdev/hiam-core).

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

## License

This project is released under the terms of the BSD-3-Clause [license](LICENSE).
Read more [here](http://choosealicense.com/licenses/bsd-3-clause).

Copyright © 2016, HiQDev (http://hiqdev.com/)
