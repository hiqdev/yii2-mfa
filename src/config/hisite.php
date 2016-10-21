<?php

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
    ],
    'modules' => [
        'mfa' => [
            'class' => \hiqdev\yii2\mfa\Module::class,
            'totp' => [
                'class' => \hiqdev\yii2\mfa\base\Totp::class,
                'workerClass' => \RobThree\Auth\TwoFactorAuth::class,
                'issuer' => !empty($params['organizationName']) ? $params['organizationName'] : 'Yii2 MFA',
            ],
        ],
    ],
];
