<?php



use yii\helpers\Html;

use yii\helpers\ArrayHelper;

use kartik\widgets\ActiveForm;

use kartik\builder\Form;

use livefactory\models\Country;
use livefactory\models\State;
use livefactory\models\City;
use kartik\widgets\DepDrop;

use kartik\datecontrol\DateControl;

use livefactory\models\CustomerType;



/**

 *

 * @var yii\web\View $this

 * @var common\models\Customer $model

 * @var yii\widgets\ActiveForm $form

 */

?>



<div class="customer-form">

    <?php

				

				$form = ActiveForm::begin ( [ 

						'type' => ActiveForm::TYPE_VERTICAL 

				] );?>

				<div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo Yii::t ( 'app', 'Client Details' ); ?></h3>
                </div>
                <div class="panel-body">
			<?php
				echo Form::widget ( [ 

						

						'model' => $model,

						'form' => $form,

						'columns' => 4,

						'attributes' => [ 

								

								'customer_name' => [ 

										'type' => Form::INPUT_TEXT,

										'options' => [ 

												'placeholder' => Yii::t ( 'app', 'Enter Company Name' ).'...',

												'maxlength' => 255 

										],

										'columnOptions' => [ 

												'colspan' => 3 

										] 

								]


								,

								

								'customer_type_id' => [ 

										'type' => Form::INPUT_DROPDOWN_LIST,

										'options' => [ 
												'prompt' => '--'.Yii::t ( 'app', 'Client Type' ).'--',

										],

										'items' => ArrayHelper::map ( CustomerType::find ()->orderBy ( 'type' )->asArray ()->all (), 'id', 'label' )  

								]

								 

						] 

				]

				 );

				

				echo Form::widget ( [ 

						

						'model' => $model,

						'form' => $form,

						'columns' => 3,

						'attributes' => [ 

								

								'first_name' => [ 

										'type' => Form::INPUT_TEXT,

										'options' => [ 

												'placeholder' => Yii::t ( 'app', 'Enter First Name' ).'...',

												'maxlength' => 255 

										] 

								],

								

								'last_name' => [ 

										'type' => Form::INPUT_TEXT,

										'options' => [ 

												'placeholder' => Yii::t ( 'app', 'Enter Last Name' ).'...',



												'maxlength' => 255 

										] 

								]
								,

								

								'email' => [ 

										'type' => Form::INPUT_TEXT,

										'options' => [ 

												'placeholder' => Yii::t ( 'app', 'Enter Email' ).'...',

												'maxlength' => 255 

										] 

								],

								

								'phone' => [ 

										'type' => Form::INPUT_TEXT,

										'options' => [ 

												'placeholder' => Yii::t ( 'app', 'Enter Phone' ).'...',

												'maxlength' => 255 

										] 

								],

								

								'fax' => [ 

										'type' => Form::INPUT_TEXT,

										'options' => [ 

												'placeholder' => Yii::t ( 'app', 'Enter Fax' ).'...', 

												'maxlength' => 255 

										] 

								],

								

								'mobile' => [ 

										'type' => Form::INPUT_TEXT,

										'options' => [ 

												'placeholder' => Yii::t ( 'app', 'Enter Mobile' ).'...' 

										] 

								] 

						] 

				] );

				

				/*echo Form::widget ( [ 

						

						'model' => $model,

						'form' => $form,

						'columns' => 4,

						'attributes' => [ 

								

								'address_id' => [ 

										'type' => Form::INPUT_TEXT,

										'options' => [ 

												'placeholder' => 'Enter Address...' 

										] 

								] 

						] 

				] );*/
				?>
                </div></div>
                <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo Yii::t ( 'app', 'Address Details' ); ?></h3>
                </div>
                <div class="panel-body">
                <div class="row">
                	<div class="col-sm-4">
                    	<div class="form-group">
                        	<label class="control-label"><?php echo Yii::t ( 'app', 'Address 1' ); ?></label>
                        	<input type="text" name="address_1" data-validation="required" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4">
                    	<div class="form-group">
                        	<label class="control-label"><?php echo Yii::t ( 'app', 'Address 2' ); ?></label>
                        	<input type="text" name="address_2" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-4">
                    	<div class="form-group">
                        	<label class="control-label"><?php echo Yii::t ( 'app', 'Zipcode' ); ?></label>
                        	<input type="text" name="zipcode" data-validation="required" class="form-control">
                        </div>
                    </div>
                </div>
                <?php
				echo '<div class="row">
						<div class="col-sm-4">
							<div class="form-group required">
								<label class="control-label">'.Yii::t ( 'app', 'Country' ).'</label>
						'.Html::dropDownList('country_id', 'country_id',
     ArrayHelper::map(Country::find()->orderBy('country')->asArray()->all(), 'id', 'country'), ['prompt' => '--'.Yii::t ( 'app', 'Select' ).'--','class'=>'form-control','id'=>'country_id','data-validation'=>'required' ]  ).'</div></div>
	 					<div class="col-sm-4">
						<div class="form-group required">
								<label class="control-label">'.Yii::t ( 'app', 'State' ).'</label>
						'.Html::dropDownList('state_id', 'state_id',
     ArrayHelper::map(State::find()->where('id=0')->orderBy('state')->asArray()->all(), 'id', 'state'), ['prompt' => '--'.Yii::t ( 'app', 'Select' ).'--','class'=>'form-control','id'=>'state_id','data-validation'=>'required' ]  ).'</div></div>
	 				<div class="col-sm-4">
						<div class="form-group required">
								<label class="control-label">'.Yii::t ( 'app', 'City' ).'</label>
						'.Html::dropDownList('city_id', 'city_id',
     ArrayHelper::map(City::find()->where('id=0')->orderBy('city')->asArray()->all(), 'id', 'city'), ['prompt' => '--'.Yii::t ( 'app', 'Select' ).'--','class'=>'form-control','id'=>'city_id' ]  ).'</div></div></div></div></div>';
				echo Html::submitButton ( $model->isNewRecord ? Yii::t ( 'app', 'Create' ) : Yii::t ( 'app', 'Update' ), [ 

						'class' => $model->isNewRecord ? 'btn btn-success customer_submit' : 'btn btn-primary customer_submit' 

				] );

				ActiveForm::end ();

				?>

</div>

