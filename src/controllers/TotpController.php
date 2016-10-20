<?php

/*
 * Identity and Access Management server providing OAuth2, RBAC and logging
 *
 * @link      https://github.com/hiqdev/hiam-core
 * @package   hiam-core
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\totp\controllers;

use hiqdev\yii2\totp\forms\InputForm;
use Yii;

/**
 * TOTP controller.
 */
class TotpController extends \yii\web\Controller
{
    public function actionEnable()
    {
        $user = Yii::$app->user->identity;
        $model = new InputForm();
        $secret = $this->module->getSecret();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($this->module->verifyCode($secret, $model->code)) {
                $user->totp_secret = $secret;
                if ($user->save() && Yii::$app->user->login($user)) {
                    Yii::$app->session->setFlash('success', Yii::t('totp', 'Two-factor authentication successfully enabled.'));
                    return $this->goBack();
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('totp', 'Sorry, we have failed to enable two-factor authentication.'));
                    return $this->goHome();
                }
            } else {
                $model->addError('code', Yii::t('totp', 'Wrong verification code. Please verify your secret and try again.'));
            }
        }

        $qrcode = $this->module->getQRCodeImageAsDataUri($user->username, $secret);

        return $this->render('enable', compact('model', 'secret', 'qrcode'));
    }

    public function actionDisable()
    {
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
                $model->addError('code', Yii::t('totp', 'Wrong verification code. Please verify your secret and try again.'));
            }
        }

        return $this->render('check', [
            'model' => $model,
            'issuer' => $this->module->issuer,
            'username' => $user->username,
        ]);
    }
}
