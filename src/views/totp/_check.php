<?php

/**
 * @var \yii\web\View $this
 * @var string $issuer
 * @var string $username
 */

?>

<h3><?= $this->title ?></h3>
<div class="row">
    <div class="col-md-12">
        <p>
            <?= Yii::t('mfa', 'Please enter the six-digit code from your app') ?>
            <br/>
            <b class="text-primary"><?= $issuer ?> (<?= $username ?>)</b>
        </p>
    </div>
</div>
