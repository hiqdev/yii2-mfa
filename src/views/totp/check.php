<?php

use hiqdev\thememanager\widgets\LoginForm;

/**
 * @var yii\web\View $this
 * @var \hiqdev\yii2\mfa\forms\InputForm $model
 */
$this->title = Yii::t('mfa', 'Two-Factor Authentication');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= LoginForm::widget([
    'model' => $model,
    'texts' => [
        'header'  => '',
        'button'  => Yii::t('mfa', 'Verify code'),
        'message' => $this->render('_check', compact('issuer', 'username')),
    ],
]) ?>
