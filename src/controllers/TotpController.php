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
    public function actionSetup()
    {
        $secret = $this->module->createSecret();
        $label = Yii::$app->user->identity->username;
        $qrcode = $this->module->getQRCodeImageAsDataUri($label, $secret);

        return $this->render('setup', compact('secret', 'qrcode'));
    }

    public function actionInput()
    {
        return $this->render('input');
    }

    public function actionCheck()
    {
        return 'ZZZ: ' . $this->module->getCode('EYUMUYTHV3UOSOWC');
    }
}
