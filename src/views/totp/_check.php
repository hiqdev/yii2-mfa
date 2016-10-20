<div class="row">
    <div class="col-md-2" align="right"><i class="fa fa-mobile fa-2x"></i></div>
    <div class="col-md-10">
        <p><?= Yii::t('totp', 'Use your two-factor authentication app to find the authentication code for {issuer} / {username}', compact('issuer', 'username')) ?></p>
    </div>
</div>
