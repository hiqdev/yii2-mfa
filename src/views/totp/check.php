<?php

use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = Yii::t('mfa', 'Two-factor authentication');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Yii::$app->themeManager->widget([
    'class' => 'LoginForm',
    'model' => $model,
    'texts' => [
        'header'  => '',
        'button'  => Yii::t('mfa', 'Verify'),
        'message' => $this->render('_check', compact('issuer', 'username')),
    ],
]) ?>
