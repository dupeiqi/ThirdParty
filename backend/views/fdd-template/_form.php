<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\base\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    
   
    <label class="control-label" for="fddtemplate-template_name">公司名称</label> 
    <?=Html::activeDropDownList($model, 'user_id', ArrayHelper::map($data,'id', 'company_name'),['prompt'=>'请选择公司','class'=>'form-control']);?>
    <?= $form->field($model, 'template_name')->textInput(['maxlength' => true])->label('模版名称') ?>
   
    <?= $form->field($model, 'template_file')->fileInput() ?>
    <label class="control-label" for="fddtemplate-template_file">模版文件:
    <?php 
    if ($model->template_file){
      echo  Html::a("文件查看","http://file.signature.com/".$model->template_file,['target'=>'blank']);
    }
    ?>    
  
    </label>
     <?php if($model->isNewRecord){$model->visible = 1;}?>
     <?= $form->field($model, 'visible')->radioList(['1'=>'可用','2'=>'不可用']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '修改', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
