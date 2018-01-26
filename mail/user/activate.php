<?php
use app\local\Html;
/** @var \app\models\User $user */
$url = ['admin/app/activate', 'id' => $user->id, 'key' => $user->activation_code];
?>

<p>Hello <?= $user->first_name ?>,</p>

<p>Welcome to <strong><?= Yii::$app->name ?></strong>.  In order to log in, you will need to activate your account.</p>

<p><?php echo Html::a('Click here', \Yii::$app->urlManager->createAbsoluteUrl($url)); ?> to activate your account.  If you
cannot click the link, you may copy and paste the following URL into your browser.</p>

<p><?php echo \Yii::$app->urlManager->createAbsoluteUrl($url); ?></p>