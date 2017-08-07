<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '法大大签署';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="signature-index">

    
<h1 style="font-size:16px;margin-bottom: 20px;"><?= Html::encode($this->title) ?></h1>
<div class="search">
    <div class="row">
        <div class="col-lg-12">
            <div class="input-search">
                <?php
                $form = ActiveForm::begin([
                            'action' => ['index'],
                            'method' => 'get',
                           
                ]);
                ?>

                <div class="input-group">
                    <?= $form->field($searchModel, 'param')->label(false)->textInput(['placeholder' => '输入合同号或交易号', 'id' => 'search']) ?>
                  
                    <?= Html::submitButton('查找', ['class' => 'btn btn-100', 'style' => 'margin-left: 0px;']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
                'attribute' => 'user_id',
                'label' => '用户名称',
                'value' => function($model) {
                    $connection = Yii::$app->db;
                    $command = $connection->createCommand('SELECT * FROM user WHERE id=' . $model->user_id);
                    $user = $command->queryOne();
                    return $user['company_name'];
                }
            ],
            'transaction_id',
            'doc_title',
            [
                'attribute' => 'contract_id',
                'label' => '合同编号',
            ],
            [
                'attribute' => 'status',
                'label' => '状态',
                'value' => function($model) {
                    return $model->status == 1 ? '成功' : '失败';
                }
            ],
                
            ['class' => 'yii\grid\ActionColumn', 'header' => '操作', 'template' => '{get-show}{get-down} {view}',
                'buttons' => [
                    'get-down' => function ($url,$model, $key) {                       
                        return Html::a('下载签暑 | ', $model->download_url, ['title' => '下载签暑', 'target' => '_blank']);
                    },
                    'get-show' => function ($url,$model, $key) {
                        return Html::a('查看签暑 | ', $model->viewpdf_url, ['title' => '查看签暑  ', 'target' => '_blank']);
                    },
                     'view' => function ($url,$model, $key) {
                        
                        return Html::a('查看详情 | ', $url, ['title' => '查看签暑  ', 'target' => '_blank']);
                    },        
                ],
                'headerOptions' => ['width' => '170']
            ],
            
        ],
    ]);
    ?>
</div>
