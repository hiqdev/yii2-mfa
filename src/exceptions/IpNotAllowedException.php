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
