<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\AssignmentHistory $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="assignment-history-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [

'from_user_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter From User ID...']], 

'to_user_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter To User ID...']], 

'entity_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Entity ID...']], 

'added_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Added At...']], 

'updated_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Updated At...']], 

'assigned_by_user_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Assigned By User ID...']], 

'from'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]], 

'to'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]], 

'entity_type'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Entity Type...', 'maxlength'=>255]], 

'notes'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter Notes...','rows'=> 6]], 

    ]


    ]);
    echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
