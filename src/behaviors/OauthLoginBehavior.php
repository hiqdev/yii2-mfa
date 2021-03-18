<?php
declare(strict_types=1);

namespace hiqdev\yii2\mfa\behaviors;

use hiqdev\yii2\mfa\Module;
use yii\base\ActionFilter;
use yii\web\Request;
use yii\web\Response;
use yii\web\User;

class OauthLoginBehavior extends ActionFilter
{
    private bool $isLogined = false;

    private User $user;
    private Request $request;
    private Response $response;
    private Module $module;

    public function __construct(
        User $user,
        Request $request,
        Response $response,
        $config = []
    ) {
        parent::__construct($config);

        $this->user = $user;
        $this->request = $request;
        $this->response = $response;
        $this->module = \Yii::$app->getModule('mfa');;
    }

    public function beforeAction($action)
    {
        if (!empty($this->user->identity)) {
            $this->isLogined = true;
            return true;
        }

        $token = $this->request->post()['access_token'] ?? '';
        $identity = $this->user->identityClass::findIdentityByAccessToken($token);
        if ($identity === null) {
            $this->response->setStatusCode(400);
            $this->response->data = ['_error' => 'invalid_token'];
            return false;
        }

        $this->module->getTotp()->setIsVerified(true);
        $this->user->login($identity);

        return true;
    }

    public function afterAction($action, $result)
    {
        if (!$this->isLogined) {
            $this->user->logout();
        }

        return parent::afterAction($action, $result);
    }
}
