<section class="login">
    <div class="login-content">
        <div class="content primary">
            <h3>Sign In</h3>
            <?php $form = \yii\widgets\ActiveForm::begin() ?>

            <?= $form->field($model, 'email')->textInput(['placeholder' => $model->getAttributeLabel('email')])->label(false) ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder' => $model->getAttributeLabel('password')])->label(false) ?>


            <div class="actions">
                <button type="submit" class="btn btn-primary btn-lg btn-rounded">Sign In</button>
            </div>

            <?php \yii\widgets\ActiveForm::end() ?>
        </div>
        <div class="content secondary">
            <div class="clip-box">
                <h3>Welcome Back!</h3>
            </div>

        </div>
    </div>

</section>