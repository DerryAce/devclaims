<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var livefactory\models\LeadType $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="lead-type-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [

'type'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Type...', 'maxlength'=>255]], 

'label'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Label...', 'maxlength'=>32]], 

'sort_order'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Sort Order...']], 

'status' => [ 
										'type' => Form::INPUT_DROPDOWN_LIST,
										'label' => 'Status',
										'options' => [ 
												'placeholder' => 'Enter Status ...' 
										] ,
										'columnOptions'=>['colspan'=>1],
										'items'=>array('0'=>'Deactivate','1'=>'Activate')  , 
										'options' => [ 
                                                'prompt' => '--Select Status--'
                                        ]
								], 

//'created_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Created At...']], 

//'updated_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Updated At...']], 

    ]


    ]);
    echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
