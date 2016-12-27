<?php

use hiqdev\thememanager\widgets\LoginForm;

/** @var yii\web\View $this */
$this->title = Yii::t('mfa', 'Two-factor authentication');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= LoginForm::widget([
    'model' => $model,
    'texts' => [
        'header'  => '',
        'button'  => Yii::t('mfa', 'Verify'),
        'message' => $this->render('_check', compact('issuer', 'username')),
    ],
]) ?>
