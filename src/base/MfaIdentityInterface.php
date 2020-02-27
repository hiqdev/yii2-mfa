<?php


namespace hiqdev\yii2\mfa\base;


use yii\web\IdentityInterface;

/**
 * Interface MfaIdentityInterface
 * @package hiqdev\yii2\mfa\base
 *
 * @property string $username
 * @property string $totp_secret
 * @property string $allowed_ips
 */
interface MfaIdentityInterface extends IdentityInterface
{
    /**
     * @return string
     */
    public function getUsername(): string;

    /**
     * @return string
     */
    public function getTotpSecret(): string;

    /**
     * @return string
     */
    public function getAllowedIps(): string;

    /**
     * @param string $username
     * @return $this
     */
    public function setUsername(string $username): self;

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
}
