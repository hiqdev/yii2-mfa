<?php

use yii\helpers\Html;

?>

<h3><?= Yii::t('totp', 'Scan this QR-code with your app') ?></h3>

<p><?= Yii::t('totp', 'Scan the image below with the two-factor authentication app on your mobile device.') ?></p>

<p><?= Yii::t('totp', 'If you can\'t use a QR-code {link}', ['link' => Html::a(Yii::t('totp', 'enter this text code instead'), '#')]) ?>: <?= $secret ?></p>

<p align="center"><?= Html::img($qrcode, ['class' => 'img-thumbnail']) ?></p>

<h3><?= Yii::t('totp', 'Enter the six-digit code from your app') ?></h3>

