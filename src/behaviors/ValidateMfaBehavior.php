<?php
/**
 * Multi-factor authentication for Yii2 projects
 *
 * @link      https://github.com/hiqdev/yii2-mfa
 * @package   yii2-mfa
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\mfa\behaviors;

use hiqdev\yii2\mfa\exceptions\AuthenticationException;
use hiqdev\yii2\mfa\Module;
use Yii;
use yii\web\User;
use yii\web\UserEvent;

class ValidateMfaBehavior extends \yii\base\Behavior
{
    public function events()
    {
        return [
            User::EVENT_BEFORE_LOGIN => 'beforeLogin',
        ];
    }

    /**
     * @param UserEvent $event
     */
    public function beforeLogin(UserEvent $event)
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('mfa');
        $identity = $event->identity;
        $module->setHalfUser($identity);

        try {
            $module->validateIps($identity);
            $module->validateTotp($identity);
        } catch (AuthenticationException $e) {
            if ($event->cookieBased) {
                $event->isValid = false;
            } else {
                $e->redirect();
            }
        }
    }
}
