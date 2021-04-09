<?php
declare(strict_types=1);

namespace hiqdev\yii2\mfa\validator;

final class BackUrlValidator implements BackUrlValidatorInterface
{
    public function validate(string $url): bool
    {
        return true;
    }
}
