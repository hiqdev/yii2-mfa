<?php

namespace hiqdev\yii2\mfa\exceptions;

use Yii;

class NotAuthenticatedException extends AuthenticationException
{
    public function getName()
    {
        return 'You are not authenticated';
    }

    public function redirect()
    {
        Yii::$app->response->redirect('/site/login');
        Yii::$app->end();
    }
}
