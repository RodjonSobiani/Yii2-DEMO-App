<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\user */

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Пожалуйста, заполните необходимые поля, чтобы зарегистрироваться в системе:</p>
    <hr/>

    <div class="form-register">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>
