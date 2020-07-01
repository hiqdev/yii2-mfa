<?php
declare(strict_types=1);

namespace hiqdev\yii2\mfa\base;

use Yii;
use yii\db\ActiveRecord;

class Recovery extends ActiveRecord
{
    public static function tableName()
    {
        return '{{mfa_recovery_codes}}';
    }

    public function rules(): array
    {
        return [
            ['user_id', 'integer'],
            ['user_id', 'required'],
            ['code', 'string'],
            ['code', 'required'],
        ];
    }

    public function setUser(int $id): self {
        $this->user_id = $id;

        return $this;
    }

    public function setCode(string $code): self {
        $this->code = $code;

        return $this;
    }

    public function save($runValidation = true, $attributeNames = null): bool
    {
        $this->code = $this->hashCode($this->code);

        return parent::save($runValidation, $attributeNames);
    }

    private function hashCode(string $code): string
    {
        return Yii::$app->security->generatePasswordHash($code);
    }
}