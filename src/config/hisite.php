<?php

return [
    'components' => [
        'i18n' => [
            'translations' => [
                'totp' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'basePath' => '@hiqdev/yii2/totp/messages',
                ],
            ],
        ],
    ],
    'modules' => [
        'totp' => [
            'class' => \hiqdev\yii2\totp\Module::class,
            'workerClass' => RobThree\Auth\TwoFactorAuth::class,
            'issuer' => !empty($params['organizationName']) ? $params['organizationName'] : 'Yii2 TOTP',
        ],
    ],
];
