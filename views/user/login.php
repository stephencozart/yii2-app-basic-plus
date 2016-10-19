<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\forms\UserForm */

use app\local\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
?>

<div class="site-login">
    <div class="container">

        <div class="row">
            <div class="col-sm-6">
                <h1><?= Html::encode($this->title) ?></h1>

                <?php Html::showFlashMessages(); ?>

                <p>Please fill out the following fields to login:</p>

                <?php $form = ActiveForm::begin(); ?>

                <?echo $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <?echo $form->field($model, 'password')->passwordInput() ?>

                <?echo $form->field($model, 'remember_me')->checkbox([
                    'template' => "<div>{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                ]) ?>

                <?echo Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

    </div>
</div>
