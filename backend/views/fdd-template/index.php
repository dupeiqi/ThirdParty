<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\User;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '模版';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('新增模版', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'user_id',
                'label' => '模版用户',
                'value' => function($model) {
                    $ret=User::findOne($model->user_id);
                    return $ret->company_name;
                }
            ],
            'template_id',
            'template_name',
            'template_file',
             [
                'attribute' => 'visible',
                'label' => '状态',
                'value' => function($model) {
                    return $model->visible == 1 ? '开启' : '禁用';
                }
            ],
           [
                'attribute' => 'updated_at',
                'label' => '更新时间',
                'value' => function($model) {
                    return date("Y-m-d H:i:s",$model->updated_at);
                }
            ],
            // 'created_at',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
