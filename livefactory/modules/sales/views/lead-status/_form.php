<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var livefactory\models\LeadStatus $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="lead-status-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 1,
    'attributes' => [

'status'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Status...', 'maxlength'=>255]],

'label'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Label...', 'maxlength'=>50]], 

'sort_order'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Sort Order...']], 

'active' => [ 
										'type' => Form::INPUT_DROPDOWN_LIST,
										'label' => 'Active',
										'options' => [ 
												'placeholder' => 'Enter State ...' 
										] ,
										'columnOptions'=>['colspan'=>1],
										'items'=>array('0'=>'No','1'=>'Yes')  , 
										'options' => [ 
                                                'prompt' => '--Select Active--'
                                        ]
								],

//'added_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Added At...']], 

//'modified_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Modified At...']],  

    ]


    ]);
    echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>
