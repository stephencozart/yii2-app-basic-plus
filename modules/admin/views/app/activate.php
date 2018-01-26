<section class="login">
    <div class="login-content">
        <div class="content primary">
            <h3>Account Activation</h3>

            <?php $form = \yii\widgets\ActiveForm::begin() ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder' => $model->getAttributeLabel('password')])->label(false) ?>

            <?= $form->field($model, 'password_confirmation')->passwordInput(['placeholder' => $model->getAttributeLabel('password_confirmation')])->label(false) ?>

            <div class="actions">
                <button type="submit" class="btn btn-primary btn-lg btn-rounded">Activate Account</button>
            </div>

            <?php \yii\widgets\ActiveForm::end() ?>
        </div>
        <div class="content secondary">
            <div class="clip-box">
                <h3>Your Invited!</h3>
            </div>

        </div>
    </div>

</section>