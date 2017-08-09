<?php



use yii\helpers\Html;

use yii\helpers\ArrayHelper;

use kartik\widgets\ActiveForm;

use kartik\builder\Form;

use kartik\datecontrol\DateControl;

use dosamigos\ckeditor\CKEditor;

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


<div class="sublead-form">
    <?php

				

				$form = ActiveForm::begin ( [ 

						'type' => ActiveForm::TYPE_VERTICAL 

				] );

				

				echo Form::widget ( [ 

						

						'model' => $sub_lead,

						'form' => $form,

						'columns' => 1,

						'attributes' => [ 

								

								'lead_title' => [ 

										'type' => Form::INPUT_TEXT,

										'options' => [ 

												'placeholder' => 'Enter Lead Name...',

												'maxlength' => 1024 

										] 

								] 

						] 

				] );
				echo Form::widget ( [ 

						

						'model' => $sub_lead,

						'form' => $form,

						'columns' => 3,

						'attributes' => [

								

								'lead_status_id' => [ 

										'type' => Form::INPUT_DROPDOWN_LIST,

										'options' => [ 

												'placeholder' => 'Enter Lead Status ID...' 

										],

										'items' => ArrayHelper::map (LeadStatus::find ()->orderBy ( 'sort_order' )->asArray ()->all (), 'id', 'status' )  , 
										'options' => [ 
                                                'prompt' => '--Select Status--'
                                        ] 

								],

								'lead_source_id' => [ 

										'type' => Form::INPUT_DROPDOWN_LIST,

										'options' => [ 

												'placeholder' => 'Enter Lead Status ID...' 

										],

										'items' => ArrayHelper::map (LeadSource::find ()->orderBy ( 'sort_order' )->asArray ()->all (), 'id', 'source' )  , 
										'options' => [ 
                                                'prompt' => '--Select Source--'
                                        ] 

								],

								

								'lead_priority_id' => [ 

										'type' => Form::INPUT_DROPDOWN_LIST,

										'options' => [ 

												'placeholder' => 'Enter Lead Priority ID...' 

										],

										'items' => ArrayHelper::map (LeadPriority::find ()->orderBy ( 'sort_order' )->asArray ()->all (), 'id', 'priority' )  , 
										'options' => [ 
                                                'prompt' => '--Select Priority--'
                                        ] 

								],
								'lead_type_id' => [ 

										'type' => Form::INPUT_DROPDOWN_LIST,

										'options' => [ 

												'placeholder' => 'Enter Lead Priority ID...' 

										],

										'items' => ArrayHelper::map (LeadType::find ()->orderBy ( 'sort_order' )->asArray ()->all (), 'id', 'type' )  , 
										'options' => [ 
                                                'prompt' => '--Select Priority--'
                                        ] 

								],

								

								'assigned_user_id' => [ 

										'type' => Form::INPUT_DROPDOWN_LIST,

										'options' => [ 

												'placeholder' => 'Enter Assigned User ID...' 

										],

										'items' => ArrayHelper::map ( User::find()->orderBy ( 'first_name' )->asArray ()->all (), 'id', 'first_name' )  , 
										'options' => [ 
                                                'prompt' => '--Assigned User--'
                                        ]  

								],
								'customer_id' => [ 

										'type' => Form::INPUT_DROPDOWN_LIST,

										'options' => [ 

												'placeholder' => 'Enter Assigned User ID...' 

										],

										'items' =>ArrayHelper::map ( Customer::find ()->orderBy ( 'first_name' )->asArray ()->all (), 'id', 'first_name'), 
										'options' => [ 
                                                'prompt' => '--Customer--'
                                        ] 

								],
						] 

				]

				 );

				

				

				?><div class="row">
             <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label" for="name">Expected Start Date:</label>
               <div class="input-group date form_datetime1" data-date="" 
               		 data-date-format="yyyy/mm/dd HH:ii:ss" data-link-field="dtp_input1">
                     <span class="input-group-addon" title="Select date & time">
                        <span class="glyphicon glyphicon-calendar"></span>
                     </span>
                    <span class="input-group-addon" title="Clear field">
                    	<span class="glyphicon glyphicon-remove"></span>
                    </span>
					<input type="text" class="form-control input-sm expected_start_datetime" name="Lead[expected_start_datetime]" value=""/>
               </div>
                </div>
            </div>
			 <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label" for="lname">Expected Completion Date:</label>
                    <div class="input-group date form_datetime2" data-date="" 
               		 data-date-format="yyyy/mm/dd HH:ii:ss" data-link-field="dtp_input1">
                     <span class="input-group-addon" title="Select date & time">
                        <span class="glyphicon glyphicon-calendar"></span>
                     </span>
                    <span class="input-group-addon" title="Clear field">
                    	<span class="glyphicon glyphicon-remove"></span>
                    </span>
					<input type="text" class="form-control input-sm expected_end_datetime" name="Lead[expected_end_datetime]"  />
					
               </div>
                </div>
            </div>
         	 <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label" for="name">Start Time:</label>
                    <div class="input-group date form_datetime3" data-date="" 
               		 data-date-format="yyyy/mm/dd HH:ii:ss" data-link-field="dtp_input1">
                     <span class="input-group-addon" title="Select date & time">
                        <span class="glyphicon glyphicon-calendar"></span>
                     </span>
                    <span class="input-group-addon" title="Clear field">
                    	<span class="glyphicon glyphicon-remove"></span>
                    </span>
					<input type="text" class="form-control input-sm actual_start_datetime" name="Lead[actual_start_datetime]" />
               </div>
                </div>
            </div>
			 <div class="col-sm-3">
                <div class="form-group">
                    <label class="control-label" for="lname">Completion Time:</label>
                    <div class="input-group date form_datetime4" data-date="" 
               		 data-date-format="yyyy/mm/dd HH:ii:ss" data-link-field="dtp_input1">
                     <span class="input-group-addon" title="Select date & time">
                        <span class="glyphicon glyphicon-calendar"></span>
                     </span>
                    <span class="input-group-addon" title="Clear field">
                    	<span class="glyphicon glyphicon-remove"></span>
                    </span>
					<input type="text" class="form-control input-sm actual_end_datetime" name="Lead[actual_end_datetime]" />
               </div>
                </div>
            </div>
			</div><?php
				echo '<div class="row">
                <div class="col-sm-12">
					<div class="form-group">
                    <label class="control-label" for="lname">Description:

                    </label>
                    <div class="controls">
                      <textarea class="form-control input-sm ckeditor" name="Lead[lead_description]"  rows="8" style="width:100%"></textarea>
                    </div>
                </div>
				</div>
			</div>';
				echo "<input type='hidden' name='Lead[parent_id]' value='".$_GET['id']."'>
				<input type='hidden' name='Lead[added_at]' value='".strtotime(date('Y-m-d'))."'>
				<input type='hidden' name='sub_lead_value' value='".$_GET['id']."'>";
				//$form->hiddenField($sub_task,'parent_id',array('value'=>$_GET['id']));

			echo Html::submitButton ( $sub_lead->isNewRecord ? 'Create' : 'Update', [ 

						'class' => $sub_lead->isNewRecord ? 'btn btn-success sublead_insert' : 'btn btn-primary sublead_insert' 

				] );

				ActiveForm::end ();
				

				

				?>

</div>

