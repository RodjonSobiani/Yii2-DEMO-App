<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Answer */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Ответы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="answer-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'date',
            'text:ntext',
            'id_user',
            'id_theme',
        ],
    ]) ?>

</div>
