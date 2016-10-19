<?php

namespace hiqdev\yii2\totp\forms;

use Yii;

/**
 * Verification code input form.
 */
class InputForm extends \yii\base\Model
{
    public $code;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['code', 'integer', 'min' => 100000, 'max' => 999999],
            ['code', 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'code' => Yii::t('totp', 'Verification Code'),
        ];
    }

}
