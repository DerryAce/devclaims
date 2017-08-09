<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use livefactory\models\Country;
use livefactory\models\State;
use livefactory\models\City;
use kartik\widgets\DepDrop;
use yii\helpers\ArrayHelper;

/**
 * @var yii\web\View $this
 * @var livefactory\models\Company $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="company-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_VERTICAL]); 
	
	?>
    <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Company Detail</h3>
                </div>
                <div class="panel-body">
    <?
	echo Form::widget([

    'model' => $model,
    'form' => $form,
    'columns' => 2,
    'attributes' => [

'company_name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Company Name...', 'maxlength'=>255]], 

'company_email'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Company Email...', 'maxlength'=>255]], 

'company_phone'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Company Phone...', 'maxlength'=>255]], 

'company_mobile'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Company Mobile...', 'maxlength'=>255]], 

'company_fax'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Company Fax...', 'maxlength'=>255]], 

//'address_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Address ID...']], 

//'created_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Created At...']], 

//'updated_at'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Updated At...']], 

    ]


    ]);?>
    		</div>
         </div>
         <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Address Detail</h3>
                </div>
                <div class="panel-body">
                <div class="row">
                	<div class="col-sm-4">
                    	<div class="form-group">
                        	<label class="control-label">Address 1</label>
                        	<input type="text" name="address_1" data-validation="required" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4">
                    	<div class="form-group">
                        	<label class="control-label">Address 2</label>
                        	<input type="text" name="address_2" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4">
                    	<div class="form-group">
                        	<label class="control-label">ZipCode:</label>
                        	<input type="text" name="zipcode" data-validation="required" class="form-control">
                        </div>
                    </div>
                </div>
                <?
				echo '<div class="row">
						<div class="col-sm-4">
							<div class="form-group required">
								<label class="control-label">Country</label>
						'.Html::dropDownList('country_id', 'country_id',
     ArrayHelper::map(Country::find()->orderBy('country')->asArray()->all(), 'id', 'country'), ['prompt' => '--Select--','class'=>'form-control','id'=>'country_id','data-validation'=>'required' ]  ).'</div></div>
	 					<div class="col-sm-4">
						<div class="form-group required">
								<label class="control-label">State</label>
						'.Html::dropDownList('state_id', 'state_id',
     ArrayHelper::map(State::find()->where('id=0')->orderBy('state')->asArray()->all(), 'id', 'state'), ['prompt' => '--Select--','class'=>'form-control','id'=>'state_id','data-validation'=>'required' ]  ).'</div></div>
	 				<div class="col-sm-4">
						<div class="form-group required">
								<label class="control-label">City</label>
						'.Html::dropDownList('city_id', 'city_id',
     ArrayHelper::map(City::find()->where('id=0')->orderBy('city')->asArray()->all(), 'id', 'city'), ['prompt' => '--Select--','class'=>'form-control','id'=>'city_id' ]  ).'</div></div></div></div></div>';
    
    echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success company_submit' : 'btn btn-primary company_submit']);
    ActiveForm::end(); ?>

</div>
