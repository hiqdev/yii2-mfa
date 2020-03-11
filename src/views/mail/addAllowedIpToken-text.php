<?php

/** @var yii\web\View $this */
/** @var \hiqdev\yii2\mfa\base\MfaIdentityInterface $user */
/** @var string $resetLink */
?>
Hello <?= $user->getUsername() ?>,

Follow the link below to reset your password:

<?= $resetLink ?>
