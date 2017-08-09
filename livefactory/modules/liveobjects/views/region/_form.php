<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var livefactory\models\Region $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="region-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [

'active'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Active...']], 

'added_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Added At...']], 

'updated_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Updated At...']], 

'region'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Region...', 'maxlength'=>100]], 

'file_path'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter File Path...', 'maxlength'=>1024]], 

    ]


    ]);
    echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
