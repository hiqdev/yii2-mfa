<?php

namespace hiqdev\yii2\totp;

use Yii;

class Module extends \yii\base\Module
{
    public $workerClass;

    public $issuer;

    public $digits = 6;

    public $period = 30;

    public $algorithm = 'sha1';

    public $qrcodeProvider;

    public $rngProvider;

    public $tmpSecretTimeout = 3600;

    public $paramPrefix = 'TOTP-';

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

    public function getSecret()
    {
        if ($this->_secret === null) {
            $expires = $this->sessionGet('tmp-expires') ?: 0;
            if (time() < $expires) {
                $this->_secret = $this->sessionGet('tmp-secret');
            }
        }
        if ($this->_secret === null) {
            $this->_secret = $this->createSecret();
            $this->sessionSet('tmp-secret', $this->_secret);
            $this->sessionSet('tmp-expires', time() + $this->tmpSecretTimeout);
        }

        return $this->_secret;
    }

    public function sessionSet($name, $value)
    {
        Yii::$app->session->set($this->paramPrefix . $name, $value);
    }

    public function sessionGet($name)
    {
        return Yii::$app->session->get($this->paramPrefix . $name);
    }

    public function getIsVerified()
    {
        if ($this->_isVerified === null) {
            $this->_isVerified = $this->sessionGet('is-verified');
        }

        return $this->_isVerified;
    }

    public function setIsVerified($value)
    {
        $this->_isVerified = $value;
        $this->sessionSet('is-verified', $value);
    }
}
