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

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'code' => Yii::t('mfa', 'Recovery code'),
        ];
    }

    public function setUser(int $id): self {
        $this->user_id = $id;

        return $this;
    }

    public function getUser(): int {
        return $this->user_id;
    }

    public function setCode(string $code): self {
        $this->code = $code;

        return $this;
    }

    public function getCode(): string {
        return $this->code;
    }

    public function save($runValidation = true, $attributeNames = null): bool
    {
        $this->code = $this->hashCode($this->code);

        return parent::save($runValidation, $attributeNames);
    }

    public function verifyCode(): bool
    {
        $recoveryCodes = self::findAll(['user_id' => $this->getUser()]);

        foreach ($recoveryCodes ?? [] as $recoveryCode){
            if (Yii::$app->getSecurity()->validatePassword($this->getCode(), $recoveryCode->getCode())){
                $recoveryCode->delete();
                return true;
            }
        }

        return false;
    }

    private function hashCode(string $code): string
    {
        return Yii::$app->security->generatePasswordHash($code);
    }
}