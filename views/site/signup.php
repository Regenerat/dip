<?php

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->registerCssFile('@web/css/site-login.css', ['depends' => [\yii\bootstrap5\BootstrapAsset::class]]);

?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row justify-content-center">
        <div class="col-lg-5 login-form-wrapper">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'login')->textInput(['autofocus' => true, 'placeholder' => 'Введите ваш логин']) ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Введите ваш пароль']) ?>

            <?= $form->field($model, 'email')->textInput(['placeholder' => 'Введите вашу электронную почту']) ?>

            <?= $form->field($model, 'phone')->textInput(['placeholder' => 'Введите ваш номер телефона']) ?>

            <div class="form-group">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
            </div>

            <div class="text-center mt-3">
                <?= Html::a('Вход', ['site/login']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
