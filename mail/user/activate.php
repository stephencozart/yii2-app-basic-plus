<?php
use app\local\Html;
/** @var \app\models\User $user */
?>

<h2>Activate Account</h2>

<p>Welcome!  To begin using your account please activate it first.</p>

<p>You can activate your account by
    <?php echo Html::a('clicking here', \Yii::$app->urlManager->createAbsoluteUrl(['user/activate', 'id' => $user->id, 'key' => $user->auth_key])); ?>.  If you
cannot click the link, you may copy and paste the following URL into your browser.</p>

<p><?php echo \Yii::$app->urlManager->createAbsoluteUrl(['user/activate', 'id' => $user->id, 'key' => $user->auth_key]); ?></p>