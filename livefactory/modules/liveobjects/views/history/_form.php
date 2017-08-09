<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\History $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="history-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [

'entity_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Entity ID...']], 

'entity_type'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Entity Type...', 'maxlength'=>255]], 

'notes'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter Notes...','rows'=> 6]], 

'added_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Added At...']], 

'updated_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Updated At...']], 

'user_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter User ID...']], 

    ]


    ]);
    echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
