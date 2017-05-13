<?php
/**
 * Multi-factor authentication for Yii2 projects
 *
 * @link      https://github.com/hiqdev/yii2-mfa
 * @package   yii2-mfa
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\mfa\forms;

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
            ['code', 'integer', 'max' => 999999],
            ['code', 'required'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'code' => Yii::t('mfa', 'Authentication code'),
        ];
    }
}
