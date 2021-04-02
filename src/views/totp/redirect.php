<?php

/**
 * @var \yii\web\View $this
 */

$this->registerJs(<<<JS
window.onload = () => setTimeout(() => window.location = '/mfa/totp/back', 1000)
JS
);

?>

<div class="center" width="100%">
    <?= Yii::t('mfa', 'Redirecting...') ?>
</div>
