<?php
declare(strict_types=1);

namespace hiqdev\yii2\mfa\GrantType;

use OAuth2\RequestInterface;
use OAuth2\ResponseInterface;
use OAuth2\Storage\UserCredentialsInterface;
use RobThree\Auth\TwoFactorAuth;

class UserCredentials extends \OAuth2\GrantType\UserCredentials
{
    private TwoFactorAuth $totpService;

    public function __construct(UserCredentialsInterface $storage)
    {
        parent::__construct($storage);

        $this->totpService = \Yii::createObject(TwoFactorAuth::class);
    }

    public function validateRequest(RequestInterface $request, ResponseInterface $response)
    {
        $result = parent::validateRequest($request, $response);
        if (!$result) {
            return $result;
        }

        $prop = new \ReflectionProperty(parent::class, 'userInfo');
        $prop->setAccessible(true);
        $userInfo = $prop->getValue($this);

        if (!$this->checkTotp($userInfo, $request)) {
            $prop->setValue($this, null);
            $response->setError(400, 'invalid_totp', 'Failed to validate TOTP');

            return false;
        }

        return true;
    }

    private function checkTotp(array $userInfo, RequestInterface $request): bool
    {
        if (empty($userInfo['totp_secret'])) {
            return true;
        }

        $code = $request->request('code');
        if (empty($code)) {
            return false;
        }

        return $this->totpService->verifyCode($userInfo['totp_secret'], $code);
    }
}
