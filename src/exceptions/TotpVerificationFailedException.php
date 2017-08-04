<?php

namespace hiqdev\yii2\mfa\exceptions;

use Yii;

class TotpVerificationFailedException extends AuthenticationException
{
    public function getName()
    {
        return 'Token verification failed';
    }

    public function redirect()
    {
        Yii::$app->response->redirect('/mfa/totp/check');
        Yii::$app->end();
    }
}
