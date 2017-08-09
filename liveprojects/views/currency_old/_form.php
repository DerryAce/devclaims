<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var livefactory\models\Currency $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="currency-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [

'status'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Status...']], 

'added_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Added At...']], 

'updated_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Updated At...']], 

'currency'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Currency...', 'maxlength'=>255]], 

'alphabetic_code'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Alphabetic Code...', 'maxlength'=>255]], 

'numeric_code'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Numeric Code...', 'maxlength'=>255]], 

'minor_unit'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Minor Unit...', 'maxlength'=>255]], 

    ]


    ]);
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
