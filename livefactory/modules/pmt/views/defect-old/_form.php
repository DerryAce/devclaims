<?php







use yii\helpers\Html;



use yii\helpers\ArrayHelper;



use kartik\widgets\ActiveForm;



use kartik\builder\Form;



use kartik\datecontrol\DateControl;



use dosamigos\ckeditor\CKEditor;



use livefactory\models\Project;



use livefactory\models\DefectStatus;



use livefactory\models\DefectPriority;



use livefactory\models\User;



use kartik\slider\Slider;







/**



 *



 * @var yii\web\View $this



 * @var common\models\Defect $model



 * @var yii\widgets\ActiveForm $form



 */



?>







<div class="defect-form">



    <?php





				$form = ActiveForm::begin ( [ 



						'type' => ActiveForm::TYPE_VERTICAL 



				] );



				



				echo Form::widget ( [ 



						



						'model' => $model,



						'form' => $form,



						'columns' => 1,



						'attributes' => [ 



								



								'defect_name' => [ 



										'type' => Form::INPUT_TEXT,



										'options' => [ 



												'placeholder' => 'Enter Defect Name...',



												'maxlength' => 1024 



										] 



								] 



						] 



				] );



				

				if(Yii::$app->user->identity->user_role_id =='1'){

					$projects =ArrayHelper::map ( Project::find ()->orderBy ( 'project_name' )->asArray ()->all (), 'id', 'project_name' ) ;	

				}else{

					$projects=ArrayHelper::map ( Project::find ()->orderBy ( 'project_name' )->where("EXISTS(Select *

FROM lot_project_user  WHERE project_id =lot_project.id and user_id=".Yii::$app->user->identity->id.")")->asArray ()->all (), 'id', 'project_name' ) ;	

				}

				if(isset($_GET['id'])){

					$users=ArrayHelper::map ( User::find ()->orderBy ( 'first_name' )->asArray ()->all (), 'id', 'first_name');

				}else{

					$users=ArrayHelper::map ( User::find ()->where('id=0')->orderBy ( 'first_name' )->asArray ()->all (), 'id', 'first_name');	

				}

				if(isset($_REQUEST['id'])){

					if(isset($_COOKIE['inserted_notes'.$_REQUEST['id']])){

						$model->progress=100;

						$model->defect_status_id=2;

					}

				}

				echo Form::widget ( [ 



						



						'model' => $model,



						'form' => $form,



						'columns' => 4,



						'attributes' => [



								



								// 'defect_id'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Defect ID...', 'maxlength'=>255]],



								



								'project_id' => [ 



										'type' => Form::INPUT_DROPDOWN_LIST,



										



										'items' =>$projects, 

										'options' => [ 

                                                'prompt' => '--Select Project--'

                                        ] 



								],



								



								'defect_status_id' => [ 



										'type' => Form::INPUT_DROPDOWN_LIST,



										'options' => [ 



												'placeholder' => 'Enter Defect Status ID...' 



										],



										'items' => ArrayHelper::map ( DefectStatus::find ()->orderBy ( 'sort_order' )->asArray ()->all (), 'id', 'status' )  , 

										'options' => [ 

                                                'prompt' => '--Select Status--'

                                        ] 



								],



								



								'defect_priority_id' => [ 



										'type' => Form::INPUT_DROPDOWN_LIST,



										'options' => [ 



												'placeholder' => 'Enter Defect Priority ID...' 



										],



										'items' => ArrayHelper::map ( DefectPriority::find ()->orderBy ( 'sort_order' )->asArray ()->all (), 'id', 'priority' )  , 

										'options' => [ 

                                                'prompt' => '--Select Priority--'

                                        ] 



								],



								



								'assigned_user_id' => [ 



										'type' => Form::INPUT_DROPDOWN_LIST,



										'options' => [ 



												'placeholder' => 'Enter Assigned User ID...' 



										],



										'items' => $users, 

										'options' => [ 

                                                'prompt' => '--Assigned User--'

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



												'placeholder' => 'Enter Time Spent...',



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



										'type' => Form::INPUT_WIDGET,



										'widgetClass' => DateControl::classname (),



										'options' => [ 



												'type' => DateControl::FORMAT_DATETIME 



										] 



								],



								'expected_end_datetime' => [ 



										'type' => Form::INPUT_WIDGET,



										'widgetClass' => DateControl::classname (),



										'options' => [ 



												'type' => DateControl::FORMAT_DATETIME 



										] 



								],



								



								'actual_start_datetime' => [ 



										'type' => Form::INPUT_WIDGET,



										'widgetClass' => DateControl::classname (),



										'options' => [ 



												'type' => DateControl::FORMAT_DATETIME



										] 



								],



								



								// 'date_added'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],



								



								// 'date_modified'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>DateControl::classname(),'options'=>['type'=>DateControl::FORMAT_DATETIME]],



								



								'actual_end_datetime' => [ 



										'type' => Form::INPUT_WIDGET,



										'widgetClass' => DateControl::classname (),



										'options' => [ 



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



								



								'defect_description' => [ 



										'type' => Form::INPUT_TEXTAREA,



										'options' => [ 



												'placeholder' => 'Enter Defect Description...',



												'rows' => 6 



										] 



								] 



						] 



				] );

				$form->field ( $model, 'defect_description' )->widget ( CKEditor::className (), [ 



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

			echo Html::submitButton ( $model->isNewRecord ?Yii::t('app','Create')  :Yii::t('app','Update') , [ 



						'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary update_defect' 



				] );



				ActiveForm::end ();

				}

				if(isset($_GET['id'])){

				

			echo "<input type='hidden' name='Defect[project_id]' value='".$model->project_id."'>";	

				}



				



				?>



</div>



