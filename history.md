# hiqdev/yii2-mfa

## [0.1.0] - 2017-10-03

- Improved documentation
    - [6355ff7] 2017-10-03 inited tests [@hiqsol]
    - [5b357e2] 2017-10-03 csfixed [@hiqsol]
    - [ef06959] 2017-10-03 fixed links in description [@hiqsol]
    - [e98fd7d] 2017-08-20 added Usage readme section [@hiqsol]
- Fixed configs
    - [04003e2] 2017-08-20 added params config [@hiqsol]
    - [0deac24] 2017-08-20 added configuration readme [@hiqsol]
    - [89ee1fa] 2017-05-13 renamed `config/web` <- config/hisite [@hiqsol]
    - [eae0e9a] 2017-05-13 csfixed [@hiqsol]
    - [6c97db2] 2017-05-13 renamed `hidev.yml` [@hiqsol]
- Refactored with behaviors, filters and exceptions
    - [b468bea] 2017-08-09 Fixed to prevent infinite redirect when logginig in via identitiy cookie [@SilverFire]
    - [c82ddcc] 2017-08-04 Refactored to throw exceptions instead of immediate actions [@SilverFire]
    - [cea0e53] 2017-08-08 Enhanced ValidateAuthenticationFilter and not-allowed-ip filter to handle cases when user is not authenticated yet [@SilverFire]
    - [4ab3974] 2017-01-06 added redirecting for totp enable/disable/toggle [@hiqsol]
    - [8aeaf5f] 2017-01-06 + `Totp::removeSecret()` [@hiqsol]
    - [ddf0b91] 2016-12-27 fixed widget calling [@hiqsol]
    - [dcc87b7] 2016-12-23 csfixed [@hiqsol]
    - [f54246d] 2016-12-23 added `ValidateMfaBehavior` [@hiqsol]
- Added sending mail
    - [3df540d] 2016-10-25 finished sending mail [@hiqsol]

## [0.0.1] - 2016-10-24

- Added basics: totp and allowed ips checking
    - [1538933] 2016-10-24 added ru translation [@hiqsol]
    - [8efb6ab] 2016-10-22 moved validateTotp/Ips from hiam-core [@hiqsol]
    - [feb2dd9] 2016-10-22 added Allowed IPs functionality [@hiqsol]
    - [0d8cba5] 2016-10-21 fixes after renaming [@hiqsol]
    - [ceea513] 2016-10-21 csfixed [@hiqsol]
    - [a55a8db] 2016-10-21 still redoing to yii2-mfa [@hiqsol]
    - [a6efe1b] 2016-10-21 splitted out Totp class [@hiqsol]
    - [e002ab5] 2016-10-21 renaming to `yii2-mfa` [@hiqsol]
    - [ea2cdab] 2016-10-21 add onBeforeLogin [@hiqsol]
    - [1cb9bf8] 2016-10-21 + user on beforeLogin config [@hiqsol]
    - [3fdf6e0] 2016-10-21 + require robthree/twofactorauth [@hiqsol]
    - [cc1882c] 2016-10-21 added totp disabling [@hiqsol]
    - [5004664] 2016-10-20 implemented totp/check [@hiqsol]
    - [85c4505] 2016-10-20 implemented totp enabling [@hiqsol]
    - [c2ca29a] 2016-10-20 redoing to module [@hiqsol]
    - [3040ebc] 2016-10-20 + config-plugin [@hiqsol]
    - [063e68e] 2016-10-19 added basics [@hiqsol]
    - [155b1d2] 2016-10-19 inited [@hiqsol]

## [Development started] - 2016-10-19

[@hiqsol]: https://github.com/hiqsol
[sol@hiqdev.com]: https://github.com/hiqsol
[@SilverFire]: https://github.com/SilverFire
[d.naumenko.a@gmail.com]: https://github.com/SilverFire
[@tafid]: https://github.com/tafid
[andreyklochok@gmail.com]: https://github.com/tafid
[@BladeRoot]: https://github.com/BladeRoot
[bladeroot@gmail.com]: https://github.com/BladeRoot
[8efb6ab]: https://github.com//commit/8efb6ab
[feb2dd9]: https://github.com//commit/feb2dd9
[0d8cba5]: https://github.com//commit/0d8cba5
[ceea513]: https://github.com//commit/ceea513
[a55a8db]: https://github.com//commit/a55a8db
[a6efe1b]: https://github.com//commit/a6efe1b
[e002ab5]: https://github.com//commit/e002ab5
[ea2cdab]: https://github.com//commit/ea2cdab
[1cb9bf8]: https://github.com//commit/1cb9bf8
[3fdf6e0]: https://github.com//commit/3fdf6e0
[cc1882c]: https://github.com//commit/cc1882c
[5004664]: https://github.com//commit/5004664
[85c4505]: https://github.com//commit/85c4505
[c2ca29a]: https://github.com//commit/c2ca29a
[3040ebc]: https://github.com//commit/3040ebc
[063e68e]: https://github.com//commit/063e68e
[155b1d2]: https://github.com//commit/155b1d2
[1538933]: https://github.com/hiqdev/yii2-mfa/commit/1538933
[6355ff7]: https://github.com/hiqdev/yii2-mfa/commit/6355ff7
[5b357e2]: https://github.com/hiqdev/yii2-mfa/commit/5b357e2
[ef06959]: https://github.com/hiqdev/yii2-mfa/commit/ef06959
[e98fd7d]: https://github.com/hiqdev/yii2-mfa/commit/e98fd7d
[04003e2]: https://github.com/hiqdev/yii2-mfa/commit/04003e2
[0deac24]: https://github.com/hiqdev/yii2-mfa/commit/0deac24
[b468bea]: https://github.com/hiqdev/yii2-mfa/commit/b468bea
[cea0e53]: https://github.com/hiqdev/yii2-mfa/commit/cea0e53
[c82ddcc]: https://github.com/hiqdev/yii2-mfa/commit/c82ddcc
[89ee1fa]: https://github.com/hiqdev/yii2-mfa/commit/89ee1fa
[eae0e9a]: https://github.com/hiqdev/yii2-mfa/commit/eae0e9a
[6c97db2]: https://github.com/hiqdev/yii2-mfa/commit/6c97db2
[4ab3974]: https://github.com/hiqdev/yii2-mfa/commit/4ab3974
[8aeaf5f]: https://github.com/hiqdev/yii2-mfa/commit/8aeaf5f
[ddf0b91]: https://github.com/hiqdev/yii2-mfa/commit/ddf0b91
[dcc87b7]: https://github.com/hiqdev/yii2-mfa/commit/dcc87b7
[f54246d]: https://github.com/hiqdev/yii2-mfa/commit/f54246d
[3df540d]: https://github.com/hiqdev/yii2-mfa/commit/3df540d
[Under development]: https://github.com/hiqdev/yii2-mfa/compare/0.0.1...HEAD
[0.0.1]: https://github.com/hiqdev/yii2-mfa/releases/tag/0.0.1
[0.1.0]: https://github.com/hiqdev/yii2-mfa/compare/0.0.1...0.1.0
