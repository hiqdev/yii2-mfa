<?php

namespace hiqdev\yii2\mfa\exceptions;

use yii\base\Exception;

abstract class AuthenticationException extends Exception
{
    abstract public function redirect();
}
