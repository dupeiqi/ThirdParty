<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\base\Signature */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Signatures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="signature-view">

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
            'company_id',
            'src_url:url',
            'dest_url:url',
            'count',
            'status',
            'updated_at',
            'created_at',
        ],
    ]) ?>

</div>
