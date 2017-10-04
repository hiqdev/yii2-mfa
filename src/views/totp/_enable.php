<?php

use yii\helpers\Html;

?>

<h4><?= Yii::t('mfa', 'Scan this QR-code with your app') ?></h4>

<p><?= Yii::t('mfa', 'Scan the image below with the two-factor authentication app on your mobile device.') ?></p>

<p><?= Yii::t('mfa', "If you can't use a QR-code") . ' ' . Yii::t('mfa', 'enter this text code instead') ?>: <?= $secret ?></p>

<p align="center"><?= Html::img($qrcode, ['class' => 'img-thumbnail']) ?></p>

<h4><?= Yii::t('mfa', 'Enter the six-digit code from your app') ?></h4>
