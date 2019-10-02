<?php

use hiqdev\thememanager\widgets\LoginForm;
use hiqdev\yii2\mfa\forms\InputForm;

/**
 * @var yii\web\View $this
 * @var InputForm $model
 */
$this->title = Yii::t('mfa', 'Two-factor authentication');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= LoginForm::widget([
    'model' => $model,
    'texts' => [
        'header'  => '',
        'button'  => Yii::t('mfa', 'DISABLE TWO-FACTOR AUTHENTICATION'),
        'message' => $this->render('_disable'),
    ],
]) ?>
