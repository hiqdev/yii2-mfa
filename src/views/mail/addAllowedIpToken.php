<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var yii\web\IdentityInterface $user */
/** @var yii\mail\MessageInterface $message */
/** @var string $token */
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/mfa/allowed-ips/not-allowed-ip', 'token' => (string) $token]);

$message->setSubject(Yii::t('mfa', 'Allow IP {ip} for {org}', ['ip' => $token->get('ip'), 'org' => Yii::$app->params['organizationName']]));

$message->renderTextBody(basename(__FILE__, '.php') . '-text', compact('user', 'resetLink'));

?>
<div class="password-reset">
    <p><?= Yii::t('mfa', 'Hello {name}', ['name' => Html::encode($user->name)]) ?>,</p>

    <p><?= Yii::t('mfa', 'Follow the link below to allow the IP address {ip}:', ['ip' => $token->get('ip')]) ?></p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
