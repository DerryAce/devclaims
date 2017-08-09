<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use livefactory\models\User;
use livefactory\models\LeadPriority;
use livefactory\models\LeadStatus;
use livefactory\models\Customer;
use yii\helpers\ArrayHelper;

/**
 *
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\Lead $searchModel
 */


function statusLabel($status)
{
	if (in_array ( strtolower ( $status ), array (
			'new',
			'business',
			'completed',
			'low' 
	) ))
	{
		$label = "<span class=\"label label-primary\">" . $status . "</span>";
	}
	else if (in_array ( strtolower ( $status ), array (
			'acquired',
			'in process',
			'medium',
			'p2',
			'p3' 
	) ))
	{
		$label = "<span class=\"label label-success\">" . $status . "</span>";
	}
	else if (in_array ( strtolower ( $status ), array (
			'individual',
			'lowest' 
	) ))
	{
		$label = "<span class=\"label label-info\">" . $status . "</span>";
	}
	else if (in_array ( strtolower ( $status ), array (
			'lost',
			'needs action',
			'highest' 
	) ))
	{
		$label = "<span class=\"label label-danger\">" . $status . "</span>";
	}
	else if (in_array ( strtolower ( $status ), array (
			'student',
			'on hold',
			'high' 
	) ))
	{
		$label = "<span class=\"label label-warning\">" . $status . "</span>";
	}
	else
	{
		$label = "<span class=\"label label-default\">" . $status . "</span>";
	}
	return $label;
}
?>


    <?php
			Yii::$app->request->enableCsrfValidation = true;
    $csrf=$this->renderDynamic('return Yii::$app->request->csrfToken;');		
Pjax::begin ();
				echo GridView::widget ( [ 
						'dataProvider' => $dataProviderLead,
						//'filterModel' => $searchModelLead,
						'columns' => [ 
								[ 
										'class' => 'yii\grid\SerialColumn' 
								],
								
								// 'id',
								[ 
										'attribute' => 'lead_id',
										'width' => '100px' 
								],
								[ 
										'attribute' => 'lead_title',
										'width' => '250px' ,
										'format' => 'raw',
										'value' => function ($model, $key, $index, $widget)
										{
											return '<a href="index.php?r=sales/lead/lead-view&id='.$model->id.'">'.$model->lead_title.'</a>';
										}
								],
								[ 
										'attribute' => 'actual_start_datetime',
										'label' => 'Start',
										'format' => 'raw',
										'width' => '150px'  ,
										'value' => function ($model, $key, $index, $widget) {
										if(isset($model->actual_start_datetime)) {
											if($model->actual_start_datetime=='0000-00-00 00:00:00'){
												return '<i>not set</i>';
											}else{
											return date('jS \of M Y H:i:s',strtotime($model->actual_start_datetime));
												}
											}
										}
								],
								[ 
										'attribute' => 'actual_end_datetime',
										'label' => 'Completed',
										'format' => 'raw',
										'width' => '150px'  ,
										'value' => function ($model, $key, $index, $widget) {
										if(isset($model->actual_end_datetime)) {
											if($model->actual_end_datetime=='0000-00-00 00:00:00'){
												return '<i>not set</i>';
											}else{
											return date('jS \of M Y H:i:s',strtotime($model->actual_end_datetime));
												}
											}
										} 
								],
								[ 
										'attribute' => 'assigned_user_id',
										'label' => 'User',
										'filterType' => GridView::FILTER_SELECT2,
										'format' => 'raw',
										'width' => '100px',
										'filter' => ArrayHelper::map ( User::find ()->orderBy ( 'first_name' )->asArray ()->all (), 'id', 'first_name' ),
										'filterWidgetOptions' => [ 
												'options' => [ 
														'placeholder' => 'All...' 
												],
												'pluginOptions' => [ 
														'allowClear' => true 
												] 
										],
										'value' => function ($model, $key, $index, $widget)
										{
											// var_dump($model->user);
											if (isset ( $model->user ) && ! empty ( $model->user->first_name ))
												return $model->user->username;
										} 
								],
								[ 
										'attribute' => 'customer_id',
										'label' => 'Customer',
										'filterType' => GridView::FILTER_SELECT2,
										'format' => 'raw',
										'width' => '120px',
										'filter' => ArrayHelper::map ( Customer::find ()->orderBy ( 'customer_name' )->asArray ()->all (), 'id', 'customer_name' ),
										'filterWidgetOptions' => [ 
												'options' => [ 
														'placeholder' => 'All...' 
												],
												'pluginOptions' => [ 
														'allowClear' => true 
												] 
										],
										'value' => function ($model, $key, $index, $widget)
										{
											if (isset ( $model->customer ) && ! empty ( $model->customer->customer_name ))
												return $model->customer->customer_name;
										} 
								],
								[ 
										'attribute' => 'lead_status_id',
										'label' => 'Status',
										'filterType' => GridView::FILTER_SELECT2,
										'format' => 'raw',
										'width' => '100px',
										'filter' => ArrayHelper::map ( LeadStatus::find ()->orderBy ( 'sort_order asc' )->asArray ()->all (), 'id', 'label' ),
										'filterWidgetOptions' => [ 
												'options' => [ 
														'placeholder' => 'All...' 
												],
												'pluginOptions' => [ 
														'allowClear' => true 
												] 
										],
										'value' => function ($model, $key, $index, $widget)
										{
											if (isset ( $model->leadStatus ) && ! empty ( $model->leadStatus->label ))
												return statusLabel ( $model->leadStatus->label );
										} 
								],
								[ 
										'attribute' => 'lead_priority_id',
										'label' => 'Priority',
										'filterType' => GridView::FILTER_SELECT2,
										'format' => 'raw',
										'width' => '100px',
										'filter' => ArrayHelper::map (LeadPriority::find ()->orderBy ( 'sort_order asc' )->asArray ()->all (), 'id', 'label' ),
										'filterWidgetOptions' => [ 
												'options' => [ 
														'placeholder' => 'All...' 
												],
												'pluginOptions' => [ 
														'allowClear' => true 
												] 
										],
										'value' => function ($model, $key, $index, $widget)
										{
											if (isset ( $model->leadPriority ) && ! empty ( $model->leadPriority->label ))
												return statusLabel ( $model->leadPriority->label );
										} 
								],
								[ 
										'attribute' => 'progress',
										'label' => 'Progress',
										'format' => 'raw',
										'width' => '100px',
										'value' => function ($model, $key, $index, $widget)
										{
											return "<div class='progress'>
  <div class='progress-bar progress-bar-info progress-bar-striped' role='progressbar' aria-valuenow='" . $model->progress . "' aria-valuemin='0' aria-valuemax='100' style='width: " . $model->progress . "%'>" . $model->progress . "</div>
</div>";
										} 
								],
								
								[ 
										'class' => 'yii\grid\ActionColumn',
										'template'=>'{update} {view} {delete}',
										'buttons' => [ 
												'width' => '100px',
												'update' => function ($url, $model)
												{
													return"<form name='frm_lead".$model->id."' action='index.php?r=sales/lead/lead-view&id=".$model->id."' method='post' style='display:inline'><input type='hidden' value='$csrf' name='_csrf'>
									<a href='#' onClick='document.frm_lead".$model->id.".submit()' title='View' target='_parent'><span class='glyphicon glyphicon-eye-open'></span></a></form>";
												} ,
												'delete' => function ($url, $model)
												{
													return Html::a ( '<span class="glyphicon glyphicon-trash"></span>', Yii::$app->urlManager->createUrl ( [ 
															'sales/lead/lead-view',
															'lead_del' => $model->id,
															'id' => $_GET['id'] 
													] ), [ 
															'title' => Yii::t ( 'yii', 'Delete' ) ,
															'onclick'=>"return confirm('Are you Sure!')"
													] );
												} ,
											'view' => function($url,$model){
												return '';
											
											}
										]
										 
								] 
						],
						'responsive' => true,
						'hover' => true,
						'condensed' => true,
						'floatHeader' => true,
						
						'panel' => [ 
								'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i>  Sub-Leads </h3>',
								'type' => 'info',
								'before'=>'<a href="javascript:void(0)" class="btn btn-success btn-sm leadScript" onClick="$(\'.leadae\').modal(\'show\');"><i class="glyphicon glyphicon-tag"></i> Add Sublead</a>',
								'showFooter' => false 
						] 
				] );
				Pjax::end ();
				?>
