<?php

use hiqdev\thememanager\widgets\LoginForm;

/** @var yii\web\View $this */
$this->title = Yii::t('mfa', 'Enable two-factor authentication');
$this->params['breadcrumbs'][] = $this->title;

?>

<?= LoginForm::widget([
    'model' => $model,
    'texts' => [
        'message' => $this->render('_enable', compact('qrcode', 'secret')),
    ],
]) ?>
