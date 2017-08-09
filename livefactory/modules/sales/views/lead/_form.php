<?php







use yii\helpers\Html;



use yii\helpers\ArrayHelper;



use kartik\widgets\ActiveForm;



use kartik\builder\Form;



use kartik\datecontrol\DateControl;



use dosamigos\ckeditor\CKEditor;



use livefactory\models\Project;



use livefactory\models\LeadStatus;



use livefactory\models\LeadPriority;

use livefactory\models\LeadType;

use livefactory\models\LeadSource;



use livefactory\models\User;

use livefactory\models\Customer;



use kartik\slider\Slider;







/**



 *



 * @var yii\web\View $this



 * @var common\models\Task $model



 * @var yii\widgets\ActiveForm $form



 */



?>







<div class="lead-form">



    <?php





				$form = ActiveForm::begin ( [ 



						'type' => ActiveForm::TYPE_VERTICAL 



				] );



				



				echo Form::widget ( [ 



						



						'model' => $model,



						'form' => $form,



						'columns' => 1,



						'attributes' => [ 



								



								'lead_title' => [ 



										'type' => Form::INPUT_TEXT,



										'options' => [ 



												'placeholder' => 'Enter '.Yii::t('app','Lead Name').'...',



												'maxlength' => 1024 



										] 



								] 



						] 



				] );



				

				/*if(isset($_GET['id'])){

					$users=ArrayHelper::map ( User::find ()->orderBy ( 'first_name' )->asArray ()->all (), 'id', 'first_name');

				}else{

					$users=ArrayHelper::map ( User::find ()->where('id=0')->orderBy ( 'first_name' )->asArray ()->all (), 'id', 'first_name');	

				}*/

				if(isset($_REQUEST['id'])){

					if(isset($_COOKIE['inserted_notes'.$_REQUEST['id']])){

						$model->progress=100;

						$model->lead_status_id=2;

					}

				}

				echo Form::widget ( [ 



						



						'model' => $model,



						'form' => $form,



						'columns' => 4,



						'attributes' => [



								



								'lead_status_id' => [ 



										'type' => Form::INPUT_DROPDOWN_LIST,



										'options' => [ 



												'placeholder' => 'Enter Lead Status ID...' 



										],



										'items' => ArrayHelper::map (LeadStatus::find ()->orderBy ( 'sort_order' )->asArray ()->all (), 'id', 'status' )  , 

										'options' => [ 

                                                'prompt' => '--Select '.Yii::t('app','Status').'--'

                                        ] 



								],



								'lead_source_id' => [ 



										'type' => Form::INPUT_DROPDOWN_LIST,



										'options' => [ 



												'placeholder' => 'Enter Lead Status ID...' 



										],



										'items' => ArrayHelper::map (LeadSource::find ()->orderBy ( 'sort_order' )->asArray ()->all (), 'id', 'source' )  , 

										'options' => [ 

                                                'prompt' => '--Select '.Yii::t('app','Source').'--'

                                        ] 



								],



								



								'lead_priority_id' => [ 



										'type' => Form::INPUT_DROPDOWN_LIST,



										'options' => [ 



												'placeholder' => 'Enter Lead Priority ID...' 



										],



										'items' => ArrayHelper::map (LeadPriority::find ()->orderBy ( 'sort_order' )->asArray ()->all (), 'id', 'priority' )  , 

										'options' => [ 

                                                'prompt' => '--Select '.Yii::t('app','Priority').'--'

                                        ] 



								],

								'lead_type_id' => [ 



										'type' => Form::INPUT_DROPDOWN_LIST,



										'options' => [ 



												'placeholder' => 'Enter Lead Priority ID...' 



										],



										'items' => ArrayHelper::map (LeadType::find ()->orderBy ( 'sort_order' )->asArray ()->all (), 'id', 'type' )  , 

										'options' => [ 

                                                'prompt' => '--Select '.Yii::t('app','Type').'--'

                                        ] 



								],



								



								'assigned_user_id' => [ 



										'type' => Form::INPUT_DROPDOWN_LIST,



										'options' => [ 



												'placeholder' => 'Enter Assigned User ID...' 



										],



										'items' => ArrayHelper::map ( User::find ()->orderBy ( 'first_name' )->asArray ()->all (), 'id', 
										function ($user, $defaultValue) {
       								 $username=$user['username']?$user['username']:$user['email'];
       								 return $user['first_name'] . ' ' . $user['last_name'].' ('.$username.')';
    }), 

										'options' => [ 

                                                'prompt' => '--'.Yii::t('app','Assigned User').'--'

                                        ] 



								],

								'customer_id' => [ 



										'type' => Form::INPUT_DROPDOWN_LIST,



										'options' => [ 



												'placeholder' => 'Enter Assigned User ID...' 



										],



										'items' =>ArrayHelper::map ( Customer::find ()->orderBy ( 'first_name' )->asArray ()->all (), 'id', 'first_name'), 

										'options' => [ 

                                                'prompt' => '--'.Yii::t('app','Customer').'--'

                                        ] 



								],



								



								/*



								'payment_rate' => [ 



										'type' => Form::INPUT_TEXT,



										'options' => [ 



												'placeholder' => 'Enter Payment Rate...' 



										] 



								],



								*/



								



								



								







								'progress' => [ 



										'type' => Form::INPUT_TEXT,

										'value'=>$model->progress?$model->progress:0,

										'options' => [ 



												'placeholder' => 'Enter Progress...' ,

												'value'=>$model->progress?$model->progress:0



										] 



								],



								



								'time_spent' => [ 



										'type' => Form::INPUT_TEXT,



										'options' => [ 



												'placeholder' => 'Enter '.Yii::t('app','Time Spent').'...',



												'maxlength' => 11,

												'value'=>$model->time_spent?$model->time_spent:0,

												'readonly'=>'readonly'



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



								



								'expected_start_datetime' => [ 

										'lable'=>Yii::t('app','Expected Start Date'),

										'type' => Form::INPUT_WIDGET,



										'widgetClass' => DateControl::classname (),



										'options' => [ 

'language' => 'eg',

												'type' => DateControl::FORMAT_DATETIME 



										] 



								],



								'expected_end_datetime' => [ 
										'lable'=>Yii::t('app','Completion Time'),


										'type' => Form::INPUT_WIDGET,



										'widgetClass' => DateControl::classname (),



										'options' => [ 

'language' => 'eg',

												'type' => DateControl::FORMAT_DATETIME 



										] 



								],



								



								'actual_start_datetime' => [ 

										'lable'=>Yii::t('app','Start Time'),

										'type' => Form::INPUT_WIDGET,



										'widgetClass' => DateControl::classname (),



										'options' => [ 

'language' => 'eg',

												'type' => DateControl::FORMAT_DATETIME



										] 



								],



								



								// 'date_added'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],



								



								// 'date_modified'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],



								



								'actual_end_datetime' => [ 

										'lable'=>Yii::t('app','Expected Start Date'),

										'type' => Form::INPUT_WIDGET,



										'widgetClass' => DateControl::classname (),



										'options' => [ 

'language' => 'eg',

												'type' => DateControl::FORMAT_DATETIME 



										] 



								] 



						] 



				] );



				



				

				if(!isset($_REQUEST['id'])){

					$model->progress=0;

				}



				$form->field ( $model, 'progress' )->widget ( Slider::classname (), [



						'value'=>0,

						



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

				if(!isset($_REQUEST['id'])){

				echo Form::widget ( [ 



						



						'model' => $model,



						'form' => $form,



						'columns' => 1,



						'attributes' => [ 



								



								'lead_description' => [ 



										'type' => Form::INPUT_TEXTAREA,



										'options' => [ 



												'placeholder' => 'Enter Lead Description...',



												'rows' => 6 



										] 



								] 



						] 



				] );

				$form->field ( $model, 'lead_description' )->widget ( CKEditor::className (), [ 



						'options' => [ 



								'rows' => 10 



						],



						'preset' => 'basic' 



				] );



				

				echo '<div class="row">

                <div class="col-sm-12">

					<div class="form-group">

                    <label class="control-label" for="lname">'.Yii::t('app','Notes').':



                    </label>

                    <div class="controls">

                      <textarea class="form-control input-sm ckeditor" name="notes" id="notes" rows="8" style="width:100%"></textarea>

                    </div>

                </div>

				</div>

			</div>';

			echo Html::submitButton ( $model->isNewRecord ? Yii::t('app','Create') : Yii::t('app','Update'), [ 



						'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary update_lead' 



				] );



				ActiveForm::end ();

				}



				



				?>



</div>



