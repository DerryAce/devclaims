<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\Config $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="config-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [

'setting_key'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Setting Key...', 'maxlength'=>255]], 

'setting_value'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter Setting Value...','rows'=> 6]], 

'setting_description'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Setting Description...', 'maxlength'=>1024]], 

'active'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Active...']], 

'date_added'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]], 

'date_modified'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]], 

'setting_type'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Setting Type...']], 

'setting_weight'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Setting Weight...']], 

'setting_group'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Setting Group...', 'maxlength'=>255]], 

'setting_label'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Setting Label...', 'maxlength'=>255]], 

'setting_options'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Setting Options...', 'maxlength'=>255]], 

    ]


    ]);
    echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
