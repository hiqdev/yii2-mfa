<?php

use hiqdev\thememanager\widgets\LoginForm;
use hiqdev\yii2\mfa\widgets\BackTOTPLinkWidget;

/**
 * @var yii\web\View $this
 * @var \hiqdev\yii2\mfa\forms\InputForm $model
 */
$this->title = Yii::t('mfa', 'Enable Two-Factor Authentication');
$this->params['breadcrumbs'][] = $this->title;

?>

<?= LoginForm::widget([
    'model' => $model,
    'texts' => [
        'message' => $this->render('_enable', compact('qrcode', 'secret')),
    ],
]) ?>

<?= BackTOTPLinkWidget::widget() ?>
