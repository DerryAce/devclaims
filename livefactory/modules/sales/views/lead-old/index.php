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
 * @var common\models\search\Task $searchModel
 */

$this->title = Yii::t ( 'app', 'Leads' );
$this->params ['breadcrumbs'] [] = $this->title;
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
<div class="task-index">
<!--
	<div class="page-header">
		<h1><?= Html::encode($this->title) ?></h1>
	</div>
	-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


        <?php 
/*
				       * echo Html::a(Yii::t('app', 'Create {modelClass}', [
				       * 'modelClass' => 'Task',
				       * ]), ['create'], ['class' => 'btn btn-success'])
				       */
								?>

<form action="" method="post" name="frm">
    <?php Yii::$app->request->enableCsrfValidation = true; ?>
    <input type="hidden" name="_csrf" value="<?php echo $this->renderDynamic('return Yii::$app->request->csrfToken;'); ?>">
    <input type="hidden" name="multiple_del" value="true">
    <?php
Pjax::begin ();
				echo GridView::widget ( [ 
						'dataProvider' => $dataProvider,
						'filterModel' => $searchModel,
						'columns' => [ 
								['class' => '\kartik\grid\CheckboxColumn'],
            					['class' => 'yii\grid\SerialColumn'],
								
								// 'id',
								'lead_id',
								// 'task_name',
								/*[ 
										'attribute' => 'task_id',
										'width' => '100px' 
								],*/
								[ 
										'attribute' => 'lead_title',
										'width' => '200px' ,
										'format' => 'raw',
										'value' => function ($model, $key, $index, $widget)
										{
											return '<a href="index.php?r=sales/lead/lead-view&id='.$model->id.'">'.$model->lead_title.'</a>';
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
										'attribute' => 'expected_end_datetime',
										'label'=>'Due',
										'filterType' => GridView::FILTER_DATETIME,
										'width' => '170px',
										'filterWidgetOptions' => [ 
												'pluginOptions' => [ 
														'format' => 'yyyy-mm-dd H:i:s' 
												] 
										],
										'value' => function ($model, $key, $index, $widget) {
										if(isset($model->expected_end_datetime)) 
											return date('F d,Y',strtotime($model->expected_end_datetime));
										} 
								],[ 
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
											// var_dump($model->taskPriority);
											if (isset ( $model->customer ) && ! empty ( $model->customer->customer_name ))
												return $model->customer->customer_name;
										} 
								],
								[ 
										'attribute' => 'lead_status_id',
										'label' => 'Status',
										'filterType' => GridView::FILTER_SELECT2,
										'format' => 'raw',
										//'width' => '100px',
										'filter' => ArrayHelper::map (LeadStatus::find ()->orderBy ( 'sort_order asc' )->asArray ()->all (), 'id', 'label' ),
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
											// var_dump($model->taskPriority);
											if (isset ( $model->leadStatus ) && ! empty ( $model->leadStatus->label ))
												return statusLabel ( $model->leadStatus->label );
										} 
								],
								[ 
										'attribute' => 'lead_priority_id',
										'label' => 'Priority',
										'filterType' => GridView::FILTER_SELECT2,
										'format' => 'raw',
										//'width' => '100px',
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
											// var_dump($model->taskPriority);
											if (isset ( $model->leadPriority ) && ! empty ( $model->leadPriority->label ))
												return statusLabel ( $model->leadPriority->label );
										} 
								],
								[ 
										'attribute' => 'progress',
										//'width'=>'80px',
										'label' => 'Progress',
										'format' => 'raw',
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
													return Html::a ( '<span class="glyphicon glyphicon-eye-open"></span>', Yii::$app->urlManager->createUrl ( [ 
															'sales/lead/lead-view',
															'id' => $model->id 
													] ), [ 
															'title' => Yii::t ( 'yii', 'Edit' ) 
													] );
												},
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
								'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> ' . Html::encode ( $this->title ) . ' </h3>',
								'type' => 'info',
								'before' => Html::a ( '<i class="glyphicon glyphicon-plus"></i> Add', [ 
										'create' 
								], [ 
										'class' => 'btn btn-success' 
								] ).' <a href="javascript:void(0)" onClick="all_del()" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete Selected</a>',
								'after' => Html::a ( '<i class="glyphicon glyphicon-repeat"></i> Reset List', [ 
										'index' 
								], [ 
										'class' => 'btn btn-info' 
								] ),
								'showFooter' => false 
						] 
				] );
				Pjax::end ();
				?>
</form>
<script>
	function all_del(){
		var r = confirm("Are you Sure!");
		if (r == true) {
			document.frm.submit()
		} else {
			
		}	
	}
</script>
</div>
