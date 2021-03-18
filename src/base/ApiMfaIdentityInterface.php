<?php
declare(strict_types=1);

namespace hiqdev\yii2\mfa\base;

use yii\web\IdentityInterface;

/**
 * Interface which describes Identity functionality to work with temporary TOTP secret via API.
 *
 * @see \hiqdev\yii2\mfa\controllers\TotpController::actionApiEnable()
 *
 * In general case temporary TOTP secret is stored in Session
 *
 * @see \hiqdev\yii2\mfa\base\Totp::getSecret()
 * @see \hiqdev\yii2\mfa\controllers\TotpController::actionEnable()
 */
interface ApiMfaIdentityInterface extends TotpSecretStorageInterface, MfaSaveInterface
{
    public function getTemporarySecret(): ?string;

    public function setTemporarySecret(?string $secret);
}
