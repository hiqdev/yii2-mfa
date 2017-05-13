<?php
/**
 * Multi-factor authentication for Yii2 projects
 *
 * @link      https://github.com/hiqdev/yii2-mfa
 * @package   yii2-mfa
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\mfa\base;

class Totp extends \yii\base\Object
{
    public $workerClass;

    public $issuer;

    public $digits = 6;

    public $period = 30;

    public $algorithm = 'sha1';

    public $qrcodeProvider;

    public $rngProvider;

    public $tmpSecretTimeout = 3600;

    public $module;

    protected $_worker;

    protected $_secret;

    protected $_isVerified;

    public function getWorker()
    {
        if ($this->_worker === null) {
            $class = $this->workerClass;
            $this->_worker = new $class(
                $this->issuer, $this->digits, $this->period, $this->algorithm,
                $this->qrcodeProvider, $this->rngProvider
            );
        }

        return $this->_worker;
    }

    public function __call($name, $args)
    {
        return call_user_func_array([$this->getWorker(), $name], $args);
    }

    public function removeSecret()
    {
        $this->module->sessionRemove('totp-tmp-secret');
    }

    public function getSecret()
    {
        if ($this->_secret === null) {
            $expires = $this->module->sessionGet('totp-tmp-expires') ?: 0;
            if (time() < $expires) {
                $this->_secret = $this->module->sessionGet('totp-tmp-secret');
            }
        }
        if ($this->_secret === null) {
            $this->_secret = $this->createSecret();
            $this->module->sessionSet('totp-tmp-secret', $this->_secret);
            $this->module->sessionSet('totp-tmp-expires', time() + $this->tmpSecretTimeout);
        }

        return $this->_secret;
    }

    public function getIsVerified()
    {
        if ($this->_isVerified === null) {
            $this->_isVerified = $this->module->sessionGet('totp-verified');
        }

        return $this->_isVerified;
    }

    public function setIsVerified($value)
    {
        $this->_isVerified = $value;
        $this->module->sessionSet('totp-verified', $value);
    }
}
