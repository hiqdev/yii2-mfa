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

    protected $_worker;

    protected $_secret;

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
            $expires = Yii::$app->session->get('tmp-totp-expires') ?: 0;
            if (time() < $expires) {
                $this->_secret = Yii::$app->session->get('tmp-totp-secret');
            }
        }
        if ($this->_secret === null) {
            $this->_secret = $this->createSecret();
            Yii::$app->session->set('tmp-totp-secret', $this->_secret);
            Yii::$app->session->set('tmp-totp-expires', time() + $this->tmpSecretTimeout);
        }

        return $this->_secret;
    }
}
