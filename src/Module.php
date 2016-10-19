<?php

namespace hiqdev\yii2\totp;

class Module extends \yii\base\Module
{
    public $workerClass;

    public $issuer;

    public $digits = 6;

    public $period = 30;

    public $algorithm = 'sha1';

    public $qrcodeProvider;

    public $rngProvider;

    protected $_worker;

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
}
