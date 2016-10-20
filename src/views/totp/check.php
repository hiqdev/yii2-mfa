<?php

use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = Yii::t('totp', 'Two-factor authentication');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Yii::$app->themeManager->widget([
    'class' => 'LoginForm',
    'model' => $model,
    'texts' => [
        'button'  => Yii::t('totp', 'Verify'),
        'message' => $this->render('_check', compact('issuer', 'username')),
    ],
]) ?>
