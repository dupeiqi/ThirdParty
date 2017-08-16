<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\base\Signature */

$this->title ='法大大签暑详情';

?>
<div class="signature-view">

    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'transaction_id',          
             [
                'attribute' => 'contract_id',
                'label' => '合同编号',
               
            ]
            ,
            'customer_id',
            'doc_title',
            'client_role',
            'sign_keyword',
             'timestamp',            
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
            [
                'attribute' => 'status',
                'label' => '状态',
                'value' => function($model) {
                    return $model->status == 1 ? '成功' : '失败';
                }
            ],
            'download_url:url',
            'viewpdf_url:url',
                
        ],
    ]) ?>

</div>
