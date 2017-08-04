<?php

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
        if (Yii::$app->user->isGuest) {
            return $this->denyAccess(new NotAuthenticatedException());
        }

        $identity = Yii::$app->user->identity;
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
