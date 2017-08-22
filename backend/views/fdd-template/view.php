<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use backend\models\User;
/* @var $this yii\web\View */
/* @var $model common\models\base\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => '浏览', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
     'model' => $model,
        'attributes' => [
            'id',           
             [
                'attribute' => 'user_id',
                'label' => '模版用户',
                'value' => function($model) {
                    $ret=User::findOne($model->user_id);
                    return $ret->company_name;
                }
            ],
            'template_name',
            'template_file',
            'template_id',
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
            [
                'attribute' => 'created_at',
                'label' => '创建时间',
                'value' => function($model) {
                    return date("Y-m-d H:i:s",$model->created_at);
                }
            ],
           
          
           
        ],
    ]) ?>

</div>
