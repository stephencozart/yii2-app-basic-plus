<?php
use app\local\Html;
/** @var \app\models\User $user */
?>

<h2>Reset Password</h2>

<p>A password reset for an account with this email has been made.  If you did not request to reset the password you can ignore this email.</p>

<p>You can reset your account password by
    <?php echo Html::a('clicking here', \Yii::$app->urlManager->createAbsoluteUrl(['user/reset', 'id' => $user->id, 'key' => $user->reset_code])); ?>.  If you
    cannot click the link, you may copy and paste the following URL into your browser.</p>

<p><?php echo \Yii::$app->urlManager->createAbsoluteUrl(['user/reset', 'id' => $user->id, 'key' => $user->reset_code]); ?></p>