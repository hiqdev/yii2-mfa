<?php
use yii\helpers\Html;
use \yii\widgets\ActiveForm;
/**
 * @var yii\web\View $this
 * @var array $codes
 */
$this->title = Yii::t('mfa', 'Two-Factor Authentication Recovery Codes');
$this->params['breadcrumbs'][] = $this->title;
?>

<h3><?= $this->title ?></h3>
<div class="row">
    <div class="col-md-12">
        <p>
            <?= Yii::t('mfa', 'Please save your recovery codes') ?>
            <br/>
            <?= Html::ul($codes, ['class' => 'list-group', 'itemOptions' => ['class' => 'item-list']]) ?>
        </p>
        <p>
            <?= ActiveForm::begin(); ?>
            <?= Html::submitButton(Yii::t('mfa', 'Ok'), ['name' => 'mfa-codes-saved']) ?>
            <?= ActiveForm::end(); ?>
        </p>
    </div>
</div>
