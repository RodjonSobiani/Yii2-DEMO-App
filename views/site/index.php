<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Главная страница';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <hr/>
    <h5>Доступные темы:</h5>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'name',
                'format' => 'html',
                'value' => function ($data) {
                    return Html::a($data->name, '/theme/view/?id=' . $data->id);
                }
            ],
            'text:ntext',
            ['attribute' => 'Ответы', 'value' => function ($data) {
                return count($data->answers);
            }]
        ],
    ]); ?>
</div>
