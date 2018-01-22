<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\forms\UserForm */

use app\local\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
?>

<section class="section login">
    <div class="container">

        <div class="row">
            <div class="col-sm-6">
                <h1 class="section-title"><?= Html::encode($this->title) ?></h1>

                <?php Html::showFlashMessages(); ?>

                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'remember_me')->checkbox([
                    'template' => "<div>{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                ]) ?>

                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

    </div>
</section>
