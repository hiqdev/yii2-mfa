<?php

/*
 * Yii2 module providing multi-factor authentication
 *
 * @link      https://github.com/hiqdev/yii2-mfa
 * @package   yii2-mfa
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016, HiQDev (http://hiqdev.com/)
 */

return [
    'components' => [
        'i18n' => [
            'translations' => [
                'mfa' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'basePath' => '@hiqdev/yii2/mfa/messages',
                ],
            ],
        ],
        'user' => [
            'on beforeLogin' => [\hiqdev\yii2\mfa\Module::class, 'onBeforeLogin'],
        ],
        'themeManager' => [
            'pathMap' => [
                '$themedViewPaths' => ['@hiqdev/yii2/mfa/views'],
            ],
        ],
    ],
    'modules' => [
        'mfa' => [
            'class' => \hiqdev\yii2\mfa\Module::class,
            'totp' => [
                'workerClass' => \RobThree\Auth\TwoFactorAuth::class,
                'issuer' => !empty($params['organizationName']) ? $params['organizationName'] : 'Yii2 MFA',
            ],
        ],
    ],
];
