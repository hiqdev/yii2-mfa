<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var hiqdev\yii2\mfa\base\MfaIdentityInterface $user */
/** @var yii\mail\MessageInterface $message */
/** @var hiqdev\php\confirmator\Token $token */
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/mfa/allowed-ips/not-allowed-ip', 'token' => (string) $token]);

$ip = $token->get('ip');
$org = Yii::$app->params['organization.name'];

$message->setSubject(Yii::t('mfa', '[{org}] Allow IP address {ip}', ['ip' => $ip, 'org' => $org]));

$message->renderTextBody(basename(__FILE__, '.php') . '-text', compact('user', 'resetLink'));

?>
<div class="password-reset">
    <p><?= Yii::t('mfa', 'Hello, {name}!', ['name' => Html::encode($user->getUsername())]) ?></p>

    <p><?= Yii::t('mfa', 'Follow the link below to allow the IP address {ip}:', ['ip' => $ip]) ?></p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
