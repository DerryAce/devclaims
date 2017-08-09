<?php



use yii\helpers\Html;

use yii\helpers\ArrayHelper;

use kartik\widgets\ActiveForm;

use kartik\builder\Form;

use kartik\datecontrol\DateControl;

use dosamigos\ckeditor\CKEditor;

use livefactory\models\ProjectType;

use livefactory\models\User;

use livefactory\models\Currency;

use livefactory\models\Customer;

use livefactory\models\ProjectStatus;

use kartik\slider\Slider;

/**

 *

 * @var yii\web\View $this

 * @var common\models\Project $model

 * @var yii\widgets\ActiveForm $form

 */

 

?>



<div class="project-form">



    <?php
			if(!empty($_GET['customer_id']))
			$model->customer_id=$_GET['customer_id'];
				

				$form = ActiveForm::begin ( [ 

						'type' => ActiveForm::TYPE_VERTICAL 

				] );

				

				echo Form::widget ( [ 

						

						'model' => $model,

						'form' => $form,

						'columns' => 4,

						'attributes' => [

								

								// 'parent_project_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Parent Project ID...']],

								'project_name' => [ 

										'type' => Form::INPUT_TEXT,

										'options' => [ 

												'placeholder' => 'Enter '.Yii::t('app','Our Reference').'...',

												'maxlength' => 255 

										],

										'columnOptions'=>['colspan'=>2], 

								] ,

								'project_type_id' => [ 

										'type' => Form::INPUT_DROPDOWN_LIST,

										'options' => [ 

												'placeholder' => 'Enter '.Yii::t('app','Claim Type').' ID...' 

										] ,

										'columnOptions'=>['colspan'=>1],

										'items'=>ArrayHelper::map(ProjectType::find()->orderBy('sort_order')->asArray()->all(), 'id', 'label')  , 

										'options' => [ 

                                                'prompt' => '--Select '.Yii::t('app','Type').'--'

                                        ] 

								],

								'customer_id' => [ 

										'type' => Form::INPUT_DROPDOWN_LIST,

										'options' => [ 

												'placeholder' => 'Enter '.Yii::t('app','Client').' ID...' 

										],

										'columnOptions'=>['colspan'=>1],

										'items'=>ArrayHelper::map(Customer::find()->orderBy('customer_name')->asArray()->all(), 'id', 'customer_name')  , 

										'options' => [ 

                                                'prompt' => '--Select '.Yii::t('app','Client').'--'

                                        ] 

								]

						]

						 

				]

				 );

				

				echo Form::widget ( [ 

						

						'model' => $model,

						'form' => $form,

						'columns' => 4,

						'attributes' => [

								

							

								

								

								

								'project_owner' => [ 

										'type' => Form::INPUT_DROPDOWN_LIST,

										'options' => [ 

												'placeholder' => 'Enter '.Yii::t('app','Case Owner').'...' 

										] ,

										'items'=>ArrayHelper::map(User::find()->orderBy('first_name')->asArray()->all(), 'id',
										function ($user, $defaultValue) {
       								$username=$user['username']?$user['username']:$user['email'];
       								 return $user['first_name'] . ' ' . $user['last_name'].' ('.$username.')';
    })  , 

										'options' => [ 

                                                'prompt' => '--Select  '.Yii::t('app','Claim User').'--'

                                        ] 

								],

								

								'project_status_id' => [

										'type' => Form::INPUT_DROPDOWN_LIST,

										'options' => [

												'placeholder' => 'Enter Case Status ID...'

										] ,

										'items'=>ArrayHelper::map(ProjectStatus::find()->orderBy('sort_order')->asArray()->all(), 'id', 'status')  , 

										'options' => [ 

                                                'prompt' => '--Select '.Yii::t('app','Status').'--'

                                        ] 

								],

								

								

								

								

								'project_currency' => [

										'type' => Form::INPUT_DROPDOWN_LIST,

										'options' => [

												'placeholder' => 'Enter Case Currency...'

										] ,

										'items'=>ArrayHelper::map(Currency::find()->orderBy('currency')->asArray()->all(), 'id', 'currency')  , 

										'options' => [ 

                                                'prompt' => '--Select '.Yii::t('app','Claim Nature').'--'

                                        ] 

								],

								

							

								'project_budget' => [ 

										'type' => Form::INPUT_TEXT,

										'options' => [ 

												'placeholder' => 'Enter '.Yii::t('app','Amount Owed').'...',

												'maxlength' => 100 

										] 

								] 

						] 

				]

				 );

				

				echo Form::widget ( [ 

						

						'model' => $model,

						'form' => $form,

						'columns' => 4,

						'attributes' => [ 

								

								'expected_start_date' => [ 

										'type' => Form::INPUT_WIDGET,

										'widgetClass' => DateControl::classname (),

										'options' => [ 
'language' => 'eg',
												'type' => DateControl::FORMAT_DATE ,

												'pluginOptions' => [

													'autoclose' => true

													] 

										] 

								],

								

								'expected_end_date' => [ 

										'type' => Form::INPUT_WIDGET,

										'widgetClass' => DateControl::classname (),

										'options' => [ 
'language' => 'eg',
												'type' => DateControl::FORMAT_DATE 

										] 

								],

								

								'actual_start_date' => [ 

										'type' => Form::INPUT_WIDGET,

										'widgetClass' => DateControl::classname (),

										'options' => [ 
'language' => 'eg',
												'type' => DateControl::FORMAT_DATE 

										] 

								],

								

								'actual_end_date' => [ 

										'type' => Form::INPUT_WIDGET,

										'widgetClass' => DateControl::classname (),

										'options' => [ 
'language' => 'eg',
												'type' => DateControl::FORMAT_DATE 

										] 

								] 

						] 

				] );

				if(!empty($_GET['id'])){

					echo $form->field ( $model, 'progress' )->widget ( Slider::classname (), [



						



						'sliderColor' => Slider::TYPE_SUCCESS,



						'handleColor' => Slider::TYPE_SUCCESS,



						'pluginOptions' => [ 



								'handle' => 'square',



								'min' => 0,



								'max' => 100,



								'step' => 10,

								



								'tooltip' => 'always' 



						] 



				] );

				}

				if(!!empty($_REQUEST['id'])){

				echo Form::widget ( [ 

						

						'model' => $model,

						'form' => $form,

						'columns' => 1,

						'attributes' => [ 

								

								'project_description' => [ 

										'type' => Form::INPUT_TEXTAREA,

										'options' => [ 

												'placeholder' => 'Enter Case Description...',

												'rows' => 10

										] 

								] 

						] 

				] );

				

				$form->field ( $model, 'project_description' )->widget ( CKEditor::className (), [ 

						'options' => [ 

								'rows' => 10

						],

						'preset' => 'basic' 

				] );

				if(!!empty($_REQUEST['id'])){

				echo '<div class="row">

                <div class="col-sm-12">

					<div class="form-group">

                    <label class="control-label" for="lname">'.Yii::t('app', 'Notes').':



                    </label>

                    <div class="controls">

                      <textarea class="form-control input-sm ckeditor" name="notes" id="notes" rows="8" style="width:100%"></textarea>

                    </div>

                </div>

				</div>

			</div>';	

				}

				echo Html::submitButton ( $model->isNewRecord ? Yii::t('app','Create') :Yii::t('app', 'Update'), [ 

						'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' 

				] );

				ActiveForm::end ();

				}

				

				if(!empty($_REQUEST['id'])){

				echo '<input type="hidden" name="Project[customer_id]" value="'.$model->customer_id.'">';	

				}
				if(!empty($_GET['customer_id']))
				echo '<input type="hidden" name="Project[customer_id]" value="'.$_GET['customer_id'].'">';

				$user_ids = array($model->project_owner,1);

				

				if(!in_array(Yii::$app->user->identity->id,$user_ids)){

						echo '<input type="hidden" name="Project[project_owner]" value="'.$model->project_owner.'">';

					}

				

				?>



</div>

