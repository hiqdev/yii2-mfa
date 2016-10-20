<?php

use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = Yii::t('totp', 'Enable two-factor authentication');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Yii::$app->themeManager->widget([
    'class' => 'LoginForm',
    'model' => $model,
    'texts' => [
        'message' => $this->render('_enable', compact('qrcode', 'secret'))
    ],
]) ?>
