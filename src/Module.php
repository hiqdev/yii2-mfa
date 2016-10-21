<?php

/*
 * Yii2 module providing multi-factor authentication
 *
 * @link      https://github.com/hiqdev/yii2-mfa
 * @package   yii2-mfa
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2016, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\yii2\mfa;

use hiqdev\yii2\mfa\base\Totp;
use Yii;
use yii\base\Event;

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

    public static function onBeforeLogin(Event $event)
    {
        //var_dump($event);
        //die();
    }
}
