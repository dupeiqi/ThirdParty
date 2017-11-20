<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\base\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'company_name')->textInput(['maxlength' => true])->label('公司名称或姓名') ?>
    <?= $form->field($model, 'id_card')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
    <?=$model -> type==1 ?  $form->field($model, 'fdd_ca')->textInput(['maxlength' => true]):'' ?>
     <!--隐藏表单，用于给js判断是否显示模板选择框-->
     <?= $model -> type==1 ? '' :Html::activeHiddenInput($model, 'fdd_ca')?>
     <?= $form->field($model, 'type')->radioList(['1'=>'公司','2'=>'个人']) ?>
    <?= $form->field($model, 'is_auto')->radioList(['1'=>'自动签','2'=>'线下手动签']) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
