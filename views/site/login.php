<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Авторизация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, заполните необходимые поля, чтобы войти в систему:</p>
    <hr/>
    <?php $form = ActiveForm::begin(); ?>

    <div class="form-register">
        <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>

        <div class="form-group">
                <?= Html::submitButton('Авторизация', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
                <a class="btn btn-primary" href="/user/create">Регистрация</a>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
