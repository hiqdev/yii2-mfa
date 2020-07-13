<?php
/**
 * Multi-factor authentication for Yii2 projects
 *
 * @link      https://github.com/hiqdev/yii2-mfa
 * @package   yii2-mfa
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2018, HiQDev (http://hiqdev.com/)
 */

return [
    'components' => [
        'i18n' => [
            'translations' => [
                'mfa' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'basePath' => dirname(__DIR__) . '/src/messages',
                ],
            ],
        ],
        'user' => [
            'as validateMfa' => \hiqdev\yii2\mfa\behaviors\ValidateMfaBehavior::class,
        ],
        'themeManager' => [
            'pathMap' => [
                '$themedViewPaths' => [dirname(__DIR__) . '/src/views'],
            ],
        ],
    ],
    'modules' => [
        'mfa' => [
            'class' => \hiqdev\yii2\mfa\Module::class,
            'totp' => [
                'workerClass' => \RobThree\Auth\TwoFactorAuth::class,
                'issuer' => !empty($params['organization.name']) ? $params['organization.name'] : 'Yii2 MFA',
            ],
        ],
    ],
];
