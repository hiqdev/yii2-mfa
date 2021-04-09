<?php
declare(strict_types=1);

namespace hiqdev\yii2\mfa\validator;

interface BackUrlValidatorInterface
{
    public function validate(string $url): bool;
}
