<?php

use app\models\Answer;
use yii\grid\GridView;
use yii\bootstrap4\Html;
use yii\widgets\DetailView;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\theme */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Темы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="theme-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            ['attribute' => 'date', 'format' => ['date', 'dd-MM-Y H:i:s']],
            'text:ntext',
        ],
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'user.name',
            'text:ntext',
            ['attribute' => 'date', 'format' => ['date', 'dd-MM-Y H:i:s']],
        ],
    ]); ?>

</div>
<?php

/* @var $this yii\web\View */
/* @var $model app\models\Answer */
/* @var $form yii\widgets\ActiveForm */
?>
<div style="display:<?= Yii::$app->user->isGuest ? 'block':'none' ?>">
    <p>Чтобы  оставлять комментарии, пожалуйста, <a href="http://yii2/site/login">авторизуйтесь</a> в системе.</p>
</div>

<div style="display:<?= !Yii::$app->user->isGuest && Yii::$app->user->identity->isActive() == 0 ? 'block':'none' ?>">
    <p>Вы забанены.</p>
</div>

<div class="answer-form" style="display:<?= !Yii::$app->user->isGuest && Yii::$app->user->identity->isActive() != 0 ? 'block':'none' ?>">

    <?php
        $form = ActiveForm::begin(['action'=>'/answer/create']);
        $answer = new Answer();
    ?>

    <?= $form->field($answer, 'text')->textarea(['rows' => 6]) ?>

    <?= $form->field($answer, 'id_theme')->hiddenInput(['value'=>$model->id])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Ответить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
