<?php

use yii\helpers\Html;

/**
 * @var $qrcode string
 * @var $secret string
 */

?>

<h4><?= Yii::t('mfa', 'Scan this QR-code with your app') ?></h4>

<p style="margin-top: 15px">
    <?= Yii::t('mfa', 'You can use Google Authenticator or another 2FA application. If you do not have any, you can download Google Authenticator in {apple} or {google}.', [
            'apple' => '<a target="_blank" href="https://apps.apple.com/gb/app/google-authenticator/id388497605">App Store</a>',
            'google' => '<a target="_blank" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2">Google Play</a>',
        ]) ?>
    <?= Yii::t('mfa', "If you can't scan the image, enter the code manually: {code}", ['code' => $secret]) ?>
</p>

<p align="center"><?= Html::img($qrcode, ['class' => 'img-thumbnail']) ?></p>

<h4><?= Yii::t('mfa', 'Enter the six-digit code below') ?></h4>
