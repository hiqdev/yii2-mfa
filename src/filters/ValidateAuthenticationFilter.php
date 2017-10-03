<?php
/**
 * Multi-factor authentication for Yii2 projects
 *
 * @link      https://github.com/hiqdev/yii2-mfa
 * @package   yii2-mfa
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\mfa\filters;

use Closure;
use hiqdev\yii2\mfa\exceptions\AuthenticationException;
use hiqdev\yii2\mfa\exceptions\NotAuthenticatedException;
use hiqdev\yii2\mfa\Module;
use Yii;
use yii\base\ActionFilter;
use yii\web\IdentityInterface;

class ValidateAuthenticationFilter extends ActionFilter
{
    /**
     * @var Closure
     */
    public $denyCallback;

    /**
     * @var bool
     */
    public $invert = false;

    public function beforeAction($action)
    {
        $identity = Yii::$app->user->identity;

        if (Yii::$app->user->isGuest || $identity === null) {
            return $this->denyAccess(new NotAuthenticatedException());
        }

        try {
            $this->validateAuthentication($identity);
        } catch (AuthenticationException $e) {
            return $this->denyAccess($e);
        }

        return true;
    }

    public function validateAuthentication(IdentityInterface $identity)
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('mfa');

        $module->validateIps($identity);
        $module->validateTotp($identity);
    }

    /**
     * @param AuthenticationException $exception
     * @return mixed
     */
    protected function denyAccess($exception)
    {
        if ($this->denyCallback instanceof Closure) {
            return call_user_func($this->denyCallback, $exception);
        }

        $exception->redirect();
    }
}
