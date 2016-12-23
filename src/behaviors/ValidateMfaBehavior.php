<?php

/*
 * Yii2 module providing multi-factor authentication
 *
 * @link      https://github.com/hiqdev/yii2-mfa
 * @package   yii2-mfa
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\mfa\behaviors;

use Yii;
use yii\base\Event;
use yii\web\User;

class ValidateMfaBehavior extends \yii\base\Behavior
{
    public function events()
    {
        return [
            User::EVENT_BEFORE_LOGIN => 'beforeLogin',
        ];
    }

    public function beforeLogin(Event $event)
    {
        $module = Yii::$app->getModule('mfa');
        $identity = $event->identity;
        $module->setHalfUser($identity);
        $module->validateIps($identity);
        $module->validateTotp($identity);
    }
}
