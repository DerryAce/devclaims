<?php



use yii\helpers\Html;

use kartik\grid\GridView;

use yii\widgets\Pjax;

use livefactory\models\User;

use livefactory\models\TaskPriority;

use livefactory\models\TaskStatus;

use livefactory\models\Project;

use yii\helpers\ArrayHelper;



/**

 *

 * @var yii\web\View $this

 * @var yii\data\ActiveDataProvider $dataProvider

 * @var common\models\search\Task $searchModel

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

						'dataProvider' => $dataProviderTask,

						//'filterModel' => $searchModelTask,

						'columns' => [ 

								[ 

										'class' => 'yii\grid\SerialColumn' 

								],

								

								// 'id',

								// 'task_id',

								// 'task_name',

								/*[ 

										'attribute' => 'task_id',

										'width' => '100px' 

								],*/

								[ 

										'attribute' => 'task_name',

										'width' => '250px' ,

										'format' => 'raw',

										'value' => function ($model, $key, $index, $widget)

										{

											return '<a href="index.php?r=pmt/task/task-view&id='.$model->id.'">'.$model->task_name.'</a>';

										}

								],

								[ 

										'attribute' => 'actual_start_datetime',

										'label' => Yii::t('app','Start'),

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

										'label' => Yii::t('app','Completed'),

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

								

								// 'task_description:ntext',

								// ['attribute'=>'actual_end_datetime','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],

								// ['attribute'=>'actual_start_datetime','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],

								// 'time_spent',

								// 'assigned_user_id',

								[ 

										'attribute' => 'assigned_user_id',

										'label' => Yii::t('app','User'),

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

								

								// 'payment_rate',

								// 'project_id',

								// ['attribute'=>'expected_start_datetime','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],

								// ['attribute'=>'expected_end_datetime','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],

								// 'task_status_id',

								// 'task_priority_id',

								[ 

										'attribute' => 'project_id',

										'label' => Yii::t('app','Project'),

										'filterType' => GridView::FILTER_SELECT2,

										'format' => 'raw',

										'width' => '120px',

										'filter' => ArrayHelper::map ( Project::find ()->orderBy ( 'project_name' )->asArray ()->all (), 'id', 'project_name' ),

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

											if (isset ( $model->project ) && ! empty ( $model->project->project_name ))

												return $model->project->project_name;

										} 

								],

								[ 

										'attribute' => 'task_status_id',

										'label' => Yii::t('app','Status'),

										'filterType' => GridView::FILTER_SELECT2,

										'format' => 'raw',

										'width' => '100px',

										'filter' => ArrayHelper::map ( TaskStatus::find ()->orderBy ( 'sort_order asc' )->asArray ()->all (), 'id', 'label' ),

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

											if (isset ( $model->taskStatus ) && ! empty ( $model->taskStatus->label ))

												return statusLabel ( $model->taskStatus->label );

										} 

								],

								[ 

										'attribute' => 'task_priority_id',

										'label' => Yii::t('app','Priority'),

										'filterType' => GridView::FILTER_SELECT2,

										'format' => 'raw',

										'width' => '100px',

										'filter' => ArrayHelper::map ( TaskPriority::find ()->orderBy ( 'sort_order asc' )->asArray ()->all (), 'id', 'label' ),

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

											if (isset ( $model->taskPriority ) && ! empty ( $model->taskPriority->label ))

												return statusLabel ( $model->taskPriority->label );

										} 

								],

								

								// ['attribute'=>'date_added','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],

								// ['attribute'=>'date_modified','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],

								// 'progress',

								[ 

										'attribute' => 'progress',

										'label' => Yii::t('app','Progress'),

										'format' => 'raw',

										'width' => '100px',

										'value' => function ($model, $key, $index, $widget)

										{

											return "<div class='progress'>

  <div class='progress-bar progress-bar-info progress-bar-striped' role='progressbar' aria-valuenow='" . $model->progress . "' aria-valuemin='0' aria-valuemax='100' style='width: " . $model->progress . "%'>" . $model->progress . "</div>

</div>";

										} 

								],

								

								// 'parent_id',

								// 'added_at',

								// 'updated_at',

								

								[ 

										'class' => 'yii\grid\ActionColumn',

										'template'=>'{update} {view} {delete}',

										'buttons' => [ 

												'width' => '100px',

												'update' => function ($url, $model)

												{

													return"<form name='frm_task".$model->id."' action='index.php?r=pmt/task/task-view&id=".$model->id."' method='post' style='display:inline'><input type='hidden' value='$csrf' name='_csrf'>

									<a href='#' onClick='document.frm_task".$model->id.".submit()' title='View' target='_parent'><span class='glyphicon glyphicon-eye-open'></span></a></form>";

													/*return Html::a ( '<span class="glyphicon glyphicon-eye-open"></span>', Yii::$app->urlManager->createUrl ( [ 

															'pmt/task/task-view',

															'id' => $model->id 

													] ), [ 

															'title' => Yii::t ( 'yii', 'Edit' ) 

													] );*/

												} ,

												'delete' => function ($url, $model)

												{

													return Html::a ( '<span class="glyphicon glyphicon-trash"></span>', Yii::$app->urlManager->createUrl ( [ 

															'pmt/task/task-view',

															'task_del' => $model->id,

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

								'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Yii::t('app','Sub-Tasks').'   </h3>',

								'type' => 'info',

								'before'=>'<a href="javascript:void(0)" class="btn btn-success btn-sm taskScript" onClick="$(\'.taskae\').modal(\'show\');"><i class="glyphicon glyphicon-tag"></i> '.Yii::t('app','Add Subtask').' </a>',

								'showFooter' => false 

						] 

				] );

				Pjax::end ();

				?>

