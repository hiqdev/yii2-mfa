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
                'workerClass' => \RobThree\Auth\TwoFactorAuth::class,
                'issuer' => !empty($params['organizationName']) ? $params['organizationName'] : 'Yii2 MFA',
            ],
        ],
    ],
];
