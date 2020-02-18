<?php


namespace hiqdev\yii2\mfa\base;


use yii\web\IdentityInterface;

/**
 * Interface MfaIdentityInterface
 * @package hiqdev\yii2\mfa\base
 *
 * @property mixed $username
 * @property mixed $totp_secret
 * @property mixed $allowed_ips
 */
interface MfaIdentityInterface extends IdentityInterface
{
    /**
     * @return mixed
     */
    public function getUsername();

    /**
     * @return mixed
     */
    public function getTotpSecret();

    /**
     * @return mixed
     */
    public function getAllowedIps();
}
