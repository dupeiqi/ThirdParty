<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\base\User */

$this->title = '修改: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => '修改', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = '修改';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'allParams'=>$allParams,
        'dataDict'=>$dataDict,
        'data'=>$data,
    ]) ?>

</div>
