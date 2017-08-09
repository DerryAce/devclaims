<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\FileInput;

/**
 *
 * @var yii\web\View $this
 * @var common\models\File $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="file-form">

    <?php
				
$form = ActiveForm::begin ( [ 
						'type' => ActiveForm::TYPE_VERTICAL,
						'options'=>['enctype'=>'multipart/form-data'] // important
				] );
				echo Form::widget ( [ 
						
						'model' => $model,
						'form' => $form,
						'columns' => 1,
						'attributes' => [ 
								
								'file_title' => [ 
										'type' => Form::INPUT_TEXT,
										'options' => [ 
												'placeholder' => 'Enter Title...',
												'maxlength' => 1024 
										] 
								] 
						]
						 
				]
				 );
				
				echo '<div class="well well-small">';
				// echo '<label class="control-label">Upload Document</label>';
				echo FileInput::widget ( [ 
						'name' => 'file',
						
						'pluginOptions' => [ 
								'showPreview' => true,
								'showCaption' => false,
								'showUpload' => false,
								'elCaptionText' => '#customCaption',
								'previewFileType' => 'any' 
						],
						'options' => [ 
								'accept' => 'video/*' 
						] 
				] );
				echo '<span id="customCaption" class="text-success">No file selected</span>';
				echo '</div>';
				
				echo Html::submitButton ( $model->isNewRecord ? 'Save' : 'Update', [ 
						'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' 
				] );
				ActiveForm::end ();
				?>

</div>
