<?php
use app\models\forms\RegisterForm;
use yii\bootstrap\ActiveForm;
use app\local\Html;

/* @var $model app\models\forms\UserForm */
/* @var \yii\web\View $this */
$this->title = "Register";

/** @var RegisterForm $model */
?>
<div class="register">
    <div class="container">
        <div class="col-sm-8">
            <h1>Register</h1>

            <?php Html::showFlashMessages(); ?>

            <?php $form = ActiveForm::begin(); ?>

            <?php echo $form->errorSummary($model); ?>

            <div class="row">
                <div class="col-sm-6">
                    <?php echo $form->field($model, 'first_name')->textInput(); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo $form->field($model, 'last_name')->textInput(); ?>
                </div>
            </div>

            <?php echo $form->field($model, 'email')->textInput(['type' => 'email']); ?>

            <div class="row">
                <div class="col-sm-6">
                    <?php echo $form->field($model, 'password')->passwordInput(); ?>
                </div>
                <div class="col-sm-6">
                    <?php echo $form->field($model, 'password_confirmation')->passwordInput(); ?>
                </div>
            </div>

            <?php echo Html::submitButton('Submit', ['class' => 'btn btn-primary']); ?>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>