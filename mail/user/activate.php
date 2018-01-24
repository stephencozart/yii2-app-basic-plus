<?php
use app\local\Html;
/** @var \app\models\User $user */
$url = ['admin/app/activate', 'id' => $user->id, 'key' => $user->activation_code];
?>

<h2>Activate Account</h2>

<p>Welcome to <?= Yii::$app->name ?>  To begin you must first activate your account by setting a password.</p>

<p>You can set your password by
    <?php echo Html::a('clicking here', \Yii::$app->urlManager->createAbsoluteUrl($url)); ?>.  If you
cannot click the link, you may copy and paste the following URL into your browser.</p>

<p><?php echo \Yii::$app->urlManager->createAbsoluteUrl($url); ?></p>