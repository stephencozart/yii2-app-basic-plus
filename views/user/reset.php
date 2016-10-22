<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\forms\PasswordResetForm */

use app\local\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Reset Password';
?>

<div class="site-login">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <div class="row">
            <div class="col-sm-6">

                <?php Html::showFlashMessages(); ?>

                <?php $form = ActiveForm::begin(); ?>

                <?php echo $form->field($model, 'password')->passwordInput(); ?>

                <?php echo $form->field($model, 'password_confirmation')->passwordInput(); ?>

                <?php echo Html::submitButton('Reset', ['class' => 'btn btn-primary']); ?>

            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
