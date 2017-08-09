<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\TaskTime $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="task-time-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [

'start_time'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]], 

'task_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Task ID...']], 

'user_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter User ID...']], 

'entry_type'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Entry Type...', 'maxlength'=>255]], 

'added_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Added At...']], 

'end_time'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]], 

'modified_by_user_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Modified By User ID...']], 

'modified_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Modified At...']], 

    ]


    ]);
    echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
