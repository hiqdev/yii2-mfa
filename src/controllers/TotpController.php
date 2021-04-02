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

use hiqdev\yii2\mfa\base\ApiMfaIdentityInterface;
use hiqdev\yii2\mfa\base\MfaIdentityInterface;
use hiqdev\yii2\mfa\behaviors\OauthLoginBehavior;
use hiqdev\yii2\mfa\forms\InputForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * TOTP controller.
 * Time-based One Time Password.
 */
class TotpController extends \yii\web\Controller
{
    private const TOTP_BACK_URL = 'totp-back-url';

    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'filterApi' => [
                'class' => OauthLoginBehavior::class,
                'only' => ['api-temporary-secret', 'api-disable', 'api-enable'],
            ],
            'access' => [
                'class' => AccessControl::class,
                'denyCallback' => [$this, 'denyCallback'],
                'rules' => [
                    // ? - guest
                    [
                        'actions' => ['check'],
                        'roles' => ['?'],
                        'allow' => true,
                    ],
                    // @ - authenticated
                    [
                        'actions' => ['enable', 'disable', 'toggle', 'api-temporary-secret', 'api-disable', 'api-enable', 'back'],
                        'roles' => ['@'],
                        'allow' => true,
                    ],
                ],
            ],
            'verbFilter' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'api-temporary-secret' => ['POST'],
                    'api-enable' => ['POST'],
                    'api-disable' => ['POST'],
                ],
            ],
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'only' => ['api-temporary-secret', 'api-disable', 'api-enable'],
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ]);
    }

    public function denyCallback()
    {
        return $this->goHome();
    }

    public function actionEnable($back = null)
    {
        /** @var MfaIdentityInterface $user */
        $user = Yii::$app->user->identity;
        if ($user->getTotpSecret()) {
            Yii::$app->session->setFlash('error', Yii::t('mfa', 'Two-factor authentication is already enabled. Disable first.'));

            return empty($back) ? $this->goHome() : $this->deferredRedirect($back);
        }

        $model = new InputForm();
        $secret = $this->module->getTotp()->getSecret();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($this->module->getTotp()->verifyCode($secret, $model->code)) {
                $user->setTotpSecret($secret);
                $this->module->getTotp()->setIsVerified(true);
                if ($user->save() && Yii::$app->user->login($user)) {
                    Yii::$app->session->setFlash('success', Yii::t('mfa', 'Two-factor authentication successfully enabled.'));

                    return empty($back) ? $this->goBack() : $this->deferredRedirect($back);
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('mfa', 'Sorry, we have failed to enable two-factor authentication.'));

                    return empty($back) ? $this->goHome() : $this->deferredRedirect($back);
                }
            } else {
                $model->addError('code', Yii::t('mfa', 'Wrong verification code. Please verify your secret and try again.'));
            }
        }

        $qrcode = $this->module->getTotp()->getQRCodeImageAsDataUri($user->getUsername(), $secret);

        return $this->render('enable', compact('model', 'secret', 'qrcode'));
    }

    public function actionDisable($back = null)
    {
        /** @var MfaIdentityInterface $user */
        $user = Yii::$app->user->identity;
        $model = new InputForm();
        $secret = $user->getTotpSecret();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($this->module->getTotp()->verifyCode($secret, $model->code)) {
                $this->module->getTotp()->removeSecret();
                $user->setTotpSecret('');
                if ($user->save()) {
                    Yii::$app->session->setFlash('success', Yii::t('mfa', 'Two-factor authentication successfully disabled.'));
                }

                return empty($back) ? $this->goBack() : $this->deferredRedirect($back);
            } else {
                $model->addError('code', Yii::t('mfa', 'Wrong verification code. Please verify your secret and try again.'));
            }
        }
        return $this->render('disable', compact('model'));
    }

    public function actionBack()
    {
        $url = \Yii::$app->getSession()->get(self::TOTP_BACK_URL);
        if (empty($url)) {
            return $this->goBack();
        }
        \Yii::$app->getSession()->remove(self::TOTP_BACK_URL);

        return $this->redirect($url);
    }

    public function deferredRedirect($url = null)
    {
        \Yii::$app->getSession()->set(self::TOTP_BACK_URL, $url);
        return $this->render('redirect');
    }

    public function actionToggle($back = null)
    {
        /** @var MfaIdentityInterface $user */
        $user = Yii::$app->user->identity;

        return empty($user->getTotpSecret()) ? $this->actionEnable($back) : $this->actionDisable($back);
    }

    public function actionCheck()
    {
        /** @var MfaIdentityInterface $user */
        $user = $this->module->getHalfUser();
        $model = new InputForm();
        $secret = $user->getTotpSecret();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($this->module->getTotp()->verifyCode($secret, $model->code)) {
                $this->module->getTotp()->setIsVerified(true);
                Yii::$app->user->login($user);

                return $this->goBack();
            } else {
                $model->addError('code', Yii::t('mfa', 'Wrong verification code. Please verify your secret and try again.'));
            }
        }

        return $this->render('check', [
            'model' => $model,
            'issuer' => $this->module->getTotp()->issuer,
            'username' => $user->getUsername(),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function goBack($defaultUrl = null)
    {
        $redirectUrl = Yii::$app->params['totpRedirectBackAction.url'];
        if (!empty($redirectUrl)) {
            return $this->redirect($redirectUrl);
        }

        return parent::goBack($defaultUrl);
    }

    public function actionApiEnable()
    {
        /** @var ApiMfaIdentityInterface $identity */
        $identity = \Yii::$app->user->identity;
        $secret = $identity->getTotpSecret();
        if (!empty($secret)) {
            return ['_error' => 'mfa already enabled' . $secret];
        }

        if (!$this->module->getTotp()->verifyCode($identity->getTemporarySecret(), $this->request->post('code', ''))) {
            return ['_error' => 'invalid totp code'];
        }

        $identity->setTotpSecret($identity->getTemporarySecret());
        $identity->setTemporarySecret(null);
        $identity->save();

        return ['id' => $identity->getId()];
    }

    public function actionApiDisable()
    {
        /** @var ApiMfaIdentityInterface $identity */
        $identity = \Yii::$app->user->identity;
        $secret = $identity->getTotpSecret();
        if (empty($secret)) {
            return ['_error' => 'mfa disabled, enable first'];
        }

        if (!$this->module->getTotp()->verifyCode($secret, $this->request->post('code', ''))) {
            return ['_error' => 'invalid totp code'];
        }

        $identity->setTotpSecret('');
        $identity->save();

        return ['id' => $identity->getId()];
    }

    public function actionApiTemporarySecret()
    {
        /** @var ApiMfaIdentityInterface $identity */
        $identity = \Yii::$app->user->identity;
        $secret = $this->module->getTotp()->getSecret();
        $identity->setTemporarySecret($secret);
        $identity->save();

        return ['secret' => $secret];
    }
}
