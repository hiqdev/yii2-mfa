<?php


namespace hiqdev\yii2\mfa\base;


use yii\web\IdentityInterface;

/**
 * Interface MfaIdentityInterface
 * @package hiqdev\yii2\mfa\base
 */
interface MfaIdentityInterface extends IdentityInterface
{
    /**
     * @inheritDoc
     *
     * @return MfaIdentityInterface
     */
    public static function findIdentity($id);

    /**
     * @inheritDoc
     *
     * @return MfaIdentityInterface
     */
    public static function findIdentityByAccessToken($token, $type = null);

    /**
     * @return string
     */
    public function getUsername(): string;

    /**
     * @return string
     */
    public function getTotpSecret(): string;

    /**
     * @return string[]
     */
    public function getAllowedIps(): array;

    /**
     * @param string $secret
     * @return $this
     */
    public function setTotpSecret(string $secret): self;

    /**
     * @param string $allowedIp
     * @return $this
     */
    public function addAllowedIp(string $allowedIp): self;

    public function getTemporarySecret(): ?string;

    public function setTemporarySecret(?string $secret): self;
}
