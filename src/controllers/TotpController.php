<?php

/*
 * Identity and Access Management server providing OAuth2, RBAC and logging
 *
 * @link      https://github.com/hiqdev/hiam-core
 * @package   hiam-core
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2014-2016, HiQDev (http://hiqdev.com/)
 */

namespace hiam\controllers;

use hiam\forms\InputTotpForm;
use Yii;

/**
 * TOTP controller.
 */
class TotpController extends \yii\web\Controller
{
    public function getTotp()
    {
        return Yii::$app->totp;
    }

    public function actionSetup()
    {
        $secret = $this->totp->createSecret();
        $label = Yii::$app->user->identity->username;
        $qrcode = $this->totp->getQRCodeImageAsDataUri($label, $secret);

        return $this->render('setup', compact('secret', 'qrcode'));
    }

    public function actionInput()
    {
        return $this->render('input');
    }

    public function actionCheck()
    {
        return 'ZZZ: ' . $this->totp->getCode('EYUMUYTHV3UOSOWC');
    }
}
