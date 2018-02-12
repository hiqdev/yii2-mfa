<?php

/** @var yii\web\View $this */
/** @var common\models\User $user */
/** @var string $resetLink */
?>
Hello <?= $user->username ?>,

Follow the link below to reset your password:

<?= $resetLink ?>
