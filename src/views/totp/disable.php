<?php

use hiqdev\thememanager\widgets\LoginForm;
use hiqdev\yii2\mfa\forms\InputForm;

/**
 * @var yii\web\View $this
 * @var InputForm $model
 */
$this->title = Yii::t('mfa', 'Two-Factor Authentication');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= LoginForm::widget([
    'model' => $model,
    'texts' => [
        'header'  => '',
        'button'  => Yii::t('mfa', 'Disable Two-Factor Authentication'),
        'message' => $this->render('_disable'),
    ],
]) ?>
