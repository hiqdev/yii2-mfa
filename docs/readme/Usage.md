This plugin provides behavior and configuration attaches it
to user component on `beforeLogin` event.
And then the behavior validates IPs and TOTP on every login.

To use this plugin you have to instantiate your `\Yii->app->user->identity` class from
`hiqdev\yii2\mfa\base\MfaIdentityInterface` and implement all of the methods,
which will return or set MFA properties. For example:

    use hiqdev\yii2\mfa\base\MfaIdentityInterface;

    class Identity implements MfaIdentityInterface
    {
        ...

        /**
         * @inheritDoc
         */
        public function getUsername(): string
        {
            return $this->username;
        }

        /**
         * @inheritDoc
         */
        public function getTotpSecret(): string
        {
            return $this->totp_secret ?? '';
        }

        ...

IPs and TOTP functions are independent and you can provide just one of properties to have only
corresponding functionality.
