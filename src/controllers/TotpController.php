<?php

/*
 * Identity and Access Management server providing OAuth2, RBAC and logging
 *
 * @link      https://github.com/hiqdev/hiam-core
 * @package   hiam-core
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\mfa\controllers;

use hiqdev\yii2\mfa\forms\InputForm;
use Yii;
use yii\filters\AccessControl;

/**
 * TOTP controller.
 */
class TotpController extends \yii\web\Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
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
                        'actions' => ['enable','disable'],
                        'roles' => ['@'],
                        'allow' => true,
                    ],
                ],
            ],
        ]);
    }

    public function denyCallback()
    {
        return $this->goHome();
    }

    public function actionEnable()
    {
        $user = Yii::$app->user->identity;
        if ($user->totp_secret) {
            Yii::$app->session->setFlash('error', Yii::t('mfa', 'Two-factor authentication is already enabled. Disable first.'));
            return $this->goHome();
        }

        $model = new InputForm();
        $secret = $this->module->getSecret();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($this->module->verifyCode($secret, $model->code)) {
                $user->totp_secret = $secret;
                if ($user->save() && Yii::$app->user->login($user)) {
                    Yii::$app->session->setFlash('success', Yii::t('mfa', 'Two-factor authentication successfully enabled.'));
                    return $this->goBack();
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('mfa', 'Sorry, we have failed to enable two-factor authentication.'));
                    return $this->goHome();
                }
            } else {
                $model->addError('code', Yii::t('mfa', 'Wrong verification code. Please verify your secret and try again.'));
            }
        }

        $qrcode = $this->module->getQRCodeImageAsDataUri($user->username, $secret);

        return $this->render('enable', compact('model', 'secret', 'qrcode'));
    }

    public function actionDisable()
    {
        $user = Yii::$app->user->identity;
        $user->totp_secret = '';
        if ($user->save()) {
            Yii::$app->session->setFlash('success', Yii::t('mfa', 'Two-factor authentication successfully disabled.'));
        }

        return $this->goBack();
    }

    public function actionCheck()
    {
        $user = Yii::$app->user->getHalfUser();
        $model = new InputForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($this->module->verifyCode($user->totp_secret, $model->code)) {
                $this->module->setIsVerified(true);
                Yii::$app->user->login($user);

                return $this->goBack();
            } else {
                $model->addError('code', Yii::t('mfa', 'Wrong verification code. Please verify your secret and try again.'));
            }
        }

        return $this->render('check', [
            'model' => $model,
            'issuer' => $this->module->issuer,
            'username' => $user->username,
        ]);
    }
}
