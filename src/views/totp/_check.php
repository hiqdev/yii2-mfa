<h3><?= $this->title ?></h3>
<div class="row">
    <div class="col-md-2" align="right"><i class="fa fa-mobile fa-4x"></i></div>
    <div class="col-md-10">
        <p>
            <?= Yii::t('mfa', 'Use your two-factor authentication app to find the authentication code for:') ?>
            <br/>
            <b class="text-primary"><?= $issuer ?> (<?= $username ?>)</b>
        </p>
    </div>
</div>
