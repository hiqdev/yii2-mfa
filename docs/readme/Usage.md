This plugin provides behavior and configuration attaches it
to user component on beforeLogin` event.
And then the behavior validates IPs and TOTP on every login.

To use this plugin you need to provide:

- `allowed_ips` readable and writable property in your **user** component for allowed IPs functionality
- `totp_secret` readable and writable property in your **user** component for TOTP functionality

IPs and TOTP functions are independent and you can provide just one of properties to have only
corresponding functionality.
