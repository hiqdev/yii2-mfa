<?php
/**
 * Multi-factor authentication for Yii2 projects
 *
 * @link      https://github.com/hiqdev/yii2-mfa
 * @package   yii2-mfa
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\mfa;

use hiqdev\yii2\mfa\base\Totp;
use hiqdev\yii2\mfa\exceptions\IpNotAllowedException;
use hiqdev\yii2\mfa\exceptions\TotpVerificationFailedException;
use Yii;
use yii\di\Instance;
use yii\helpers\StringHelper;
use yii\validators\IpValidator;
use yii\web\IdentityInterface;

/**
 * Multi-factor authentication module.
 *
 * @author Andrii Vasyliev <sol@hiqdev.com>
 */
class Module extends \yii\base\Module
{
    public $paramPrefix = 'MFA-';

    protected $_totp;

    public function setTotp($value)
    {
        $this->_totp = $value;
    }

    public function getTotp()
    {
        if (!is_object($this->_totp)) {
            $this->_totp = Instance::ensure($this->_totp, Totp::class);
            $this->_totp->module = $this;
        }

        return $this->_totp;
    }

    public function sessionSet($name, $value)
    {
        Yii::$app->session->set($this->paramPrefix . $name, $value);
    }

    public function sessionGet($name)
    {
        return Yii::$app->session->get($this->paramPrefix . $name);
    }

    public function sessionRemove($name)
    {
        return Yii::$app->session->remove($this->paramPrefix . $name);
    }

    public function setHalfUser($value)
    {
        $this->sessionSet('halfUser', $value);
    }

    public function getHalfUser()
    {
        return $this->sessionGet('halfUser');
    }

    public function removeHalfUser()
    {
        $this->sessionRemove('halfUser');
    }

    public function validateIps(IdentityInterface $identity)
    {
        if (empty($identity->allowed_ips)) {
            return;
        }
        $ips = array_filter(StringHelper::explode($identity->allowed_ips));
        $validator = new IpValidator([
            'ipv6' => false,
            'ranges' => $ips,
        ]);
        if ($validator->validate(Yii::$app->request->getUserIP())) {
            return;
        }

        throw new IpNotAllowedException();
    }

    public function validateTotp(IdentityInterface $identity)
    {
        if (empty($identity->totp_secret)) {
            return;
        }
        if ($this->getTotp()->getIsVerified()) {
            return;
        }

        throw new TotpVerificationFailedException();
    }
}
