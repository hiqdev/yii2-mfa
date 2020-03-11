<?php
/**
 * Multi-factor authentication for Yii2 projects
 *
 * @link      https://github.com/hiqdev/yii2-mfa
 * @package   yii2-mfa
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2018, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\mfa\controllers;

use hiqdev\php\confirmator\ServiceInterface;
use hiqdev\yii2\mfa\base\MfaIdentityInterface;
use hiqdev\yii2\mfa\exceptions\AuthenticationException;
use hiqdev\yii2\mfa\filters\ValidateAuthenticationFilter;
use Yii;
use yii\filters\AccessControl;

/**
 * Allowed IPs controller.
 */
class AllowedIpsController extends \yii\web\Controller
{
    /**
     * @var ServiceInterface
     */
    private $confirmator;

    public function __construct($id, $module, ServiceInterface $confirmator, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->confirmator = $confirmator;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['not-allowed-ip', 'other'],
                'denyCallback' => function () {
                    return $this->goHome();
                },
                'rules' => [
                    [
                        'actions' => ['not-allowed-ip'],
                        'allow' => true,
                        'matchCallback' => function ($action) {
                            $filter = new ValidateAuthenticationFilter();

                            $identity = Yii::$app->user->identity ?: $this->module->getHalfUser();

                            if ($identity === null) {
                                return false;
                            }

                            try {
                                $filter->validateAuthentication($identity);
                            } catch (AuthenticationException $e) {
                                // Show this page only when user have problems with IP
                                return true;
                            }

                            return false;
                        },
                    ],
                ],
            ],
        ];
    }

    public function actionNotAllowedIp($token = null)
    {
        $ip = Yii::$app->request->getUserIP();
        /** @var MfaIdentityInterface $user */
        $user = $this->module->getHalfUser();
        if ($user && $token === 'send') {
            if ($this->confirmator->mailToken($user, 'add-allowed-ip', ['ip' => $ip])) {
                Yii::$app->session->setFlash('success', Yii::t('mfa', 'Check your email for further instructions.'));
            } else {
                Yii::$app->session->setFlash('error', Yii::t('mfa', 'Sorry, we are unable to add allowed IP for the user.'));
            }

            return $this->goHome();
        }
        if ($user && $token) {
            $token = $this->confirmator->findToken($token);
            if ($token && $token->check([
                'username' => $user->getUsername(),
                'action' => 'add-allowed-ip',
                'ip' => $ip,
            ])) {
                $user->addAllowedIp($ip);
                if ($user->save() && Yii::$app->user->login($user)) {
                    Yii::$app->session->setFlash('success', Yii::t('mfa', 'Now you are allowed to login from {ip}.', ['ip' => $ip]));

                    return $this->goBack();
                }
            }
            Yii::$app->session->setFlash('error', Yii::t('mfa', 'Sorry, we are unable to add allowed IP for the user.'));

            return $this->goHome();
        }

        return $this->render('notAllowedIp', compact('ip'));
    }
}
