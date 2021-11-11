<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Модерация тем';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="theme-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'Имя',
                'format' => 'raw',
                'value' => function($model){
                    $result = '';
                    if (isset($model->user->name)){
                        $result .= $model->user->name . ' ';
                    }
                    if (isset($model->user->surname)){
                        $result .= $model->user->surname . ' ';
                    }
                    return $result;
                },
            ],
            'name',
            'text:ntext',
            ['attribute' => 'status', 'value' => function ($data) {
                return $data->getStatusText();
            }],
            ['attribute' => 'date', 'format' => ['date', 'd.MM.Y - H:i:s']],

            [
                'attribute' => 'Администрирование',
                'format' => 'html',
                'value' => function ($data) {
                    switch ($data->status) {
                        case 1:
                            return Html::a('Одобрить', 'approve/?id=' . $data->id) . " | " .
                            Html::a('Отклонить', 'reject/?id=' . $data->id);
                        case 2:
                            return Html::a('Отклонить', 'reject/?id=' . $data->id);
                        case 0:
                            return Html::a('Одобрить', 'approve/?id=' . $data->id);
                    }
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
