<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var common\models\Employee $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="employee-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [

'employee_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Employee ID...', 'maxlength'=>255]], 

'first_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter First Name...', 'maxlength'=>255]], 

'middle_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Middle Name...', 'maxlength'=>32]], 

'last_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Last Name...', 'maxlength'=>255]], 

'phone'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Phone...', 'maxlength'=>255]], 

'user_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter User ID...']], 

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
