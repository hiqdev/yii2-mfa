<?php

namespace hiqdev\yii2\mfa\exceptions;

use Yii;

class IpNotAllowedException extends AuthenticationException
{
    public function getName()
    {
        return 'IP address is not allowed';
    }

    public function redirect()
    {
        Yii::$app->response->redirect('/mfa/allowed-ips/not-allowed-ip');
        Yii::$app->end();
    }
}
