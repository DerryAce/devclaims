<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var livefactory\models\Contact $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="contact-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [

'first_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter First Name...', 'maxlength'=>255]], 

'middle_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Middle Name...', 'maxlength'=>32]], 

'last_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Last Name...', 'maxlength'=>255]], 

'phone'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Phone...', 'maxlength'=>255]], 

'entity_type'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Entity Type...', 'maxlength'=>255]], 

'entity_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Entity ID...']], 

'created_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Created At...']], 

'updated_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Updated At...']], 

'mobile'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Mobile...']], 

'fax'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Fax...']], 

'email'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Email...', 'maxlength'=>255]], 

    ]


    ]);
    echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
