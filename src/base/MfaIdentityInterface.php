<?php


namespace hiqdev\yii2\mfa\base;


use yii\web\IdentityInterface;

/**
 * Interface MfaIdentityInterface
 * @package hiqdev\yii2\mfa\base
 */
interface MfaIdentityInterface extends IdentityInterface, TotpSecretStorageInterface, MfaSaveInterface
{
    /**
     * @inheritDoc
     *
     * @return MfaIdentityInterface|null
     */
    public static function findIdentity($id);

    /**
     * @inheritDoc
     *
     * @return MfaIdentityInterface|null
     */
    public static function findIdentityByAccessToken($token, $type = null);

    /**
     * @return string
     */
    public function getUsername(): string;

    /**
     * @return string[]
     */
    public function getAllowedIps(): array;

    /**
     * @param string $allowedIp
     */
    public function addAllowedIp(string $allowedIp);
}
