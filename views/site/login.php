<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

// Register the CSS file
$this->registerCssFile('@web/css/site-login.css', ['depends' => [\yii\bootstrap5\BootstrapAsset::class]]);

?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row justify-content-center">
        <div class="col-lg-5 login-form-wrapper">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'login')->textInput(['autofocus' => true, 'placeholder' => 'Введите логин']) ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Введите пароль']) ?>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"form-check\">{input} {label}</div>\n{error}",
                'class' => 'form-check-input',
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
            </div>

            <div class="text-center mt-3">
                <?= Html::a('Регистрация', ['site/signup']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
