<?php
declare(strict_types=1);

namespace hiqdev\yii2\mfa\base;

interface TotpSecretStorageInterface
{
    /**
     * @return string
     */
    public function getTotpSecret(): string;

    /**
     * @param string $secret
     */
    public function setTotpSecret(string $secret);
}
