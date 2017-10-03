<?php
/**
 * Multi-factor authentication for Yii2 projects
 *
 * @link      https://github.com/hiqdev/yii2-mfa
 * @package   yii2-mfa
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

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
