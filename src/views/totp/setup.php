<?php

use yii\helpers\Html;

$this->title = Yii::t('hiam', 'TOTP setup');

?>

<h1><?= $this->title ?></h1>

<p><?= $secret ?></p>
<p><?= Html::img($qrcode) ?></p>
