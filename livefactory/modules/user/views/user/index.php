<?php



use yii\helpers\Html;

use kartik\grid\GridView;

use yii\widgets\Pjax;

use livefactory\models\UserType;

use livefactory\models\UserRole;

use yii\helpers\ArrayHelper;



/**

 *

 * @var yii\web\View $this

 * @var yii\data\ActiveDataProvider $dataProvider

 * @var common\models\search\User $searchModel

 */

$this->title = Yii::t ( 'app', 'Users' );

$this->params ['breadcrumbs'] [] = $this->title;

?>

<div class="user-index">

	<!--

	<div class="page-header">

		<h1><?= Html::encode($this->title) ?></h1>

	</div>

	-->

    <?php 

	//var_dump(ArrayHelper::map ( UserType::find ()->orderBy ( 'label' )->asArray ()->all (), 'id', 'label' ));

	$status = array('0'=>Yii::t('app', 'Inactive'),'10'=>Yii::t('app', 'Active'));

	// echo $this->render('_search', ['model' => $searchModel]); ?>

    <!--<p> -->

        <?php

								/*

								 * echo Html::a(Yii::t('app', 'Create {modelClass}', [

								 * 'modelClass' => 'User',

								 * ]), ['create'], ['class' => 'btn btn-success'])

								 */

								?>

<!--    </p> -->



    <?php

				

				Pjax::begin ();

				echo GridView::widget ( [ 

						'dataProvider' => $dataProvider,

						'filterModel' => $searchModel,

						'columns' => [ 

								[ 

										'class' => 'yii\grid\SerialColumn' 

								],

								[ 

										'attribute' => 'id',

										'label' => Yii::t('app', 'Image'),

										'format' => 'raw',

										'width' => '50px',

										'value' => function ($model, $key, $index, $widget)

										{

												$users='<div class="project-people">';

														$path='../users/'.$model->id.'.png';

														if(file_exists($path)){

															$image='<img  src="../users/'.$model->id.'.png">';								

														 }else{ 

															$image='<img src="../users/nophoto.jpg">';

														 }

														$users.=' <a href="index.php?r=user/user/update&id='.$model->id.'&edit=t">'.$image.'</a>';	

												$users.='</div>';

												return $users;

										} 

								],

								// 'id',

								'first_name',

								'last_name',

								'username',

								

								// 'auth_key',

								// 'password_hash',

								// 'password_reset_token',

								'email:email',

								

								[ 

										'attribute' => 'user_type_id',

									//	'label' => 'Type',

										'filterType' => GridView::FILTER_SELECT2,

										'format' => 'raw',

										'width' => '150px',

										'filter' => ArrayHelper::map ( UserType::find ()->orderBy ( 'label' )->asArray ()->all (), 'id', 'label' ),

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

											if (isset ( $model->userType ) && ! empty ( $model->userType->label ))

												return $model->userType->label;

										} 

								],

								[ 

										'attribute' => 'user_role_id',

									//	'label' => 'Role',

										'filterType' => GridView::FILTER_SELECT2,

										'format' => 'raw',

										'width' => '150px',

										'filter' => ArrayHelper::map ( UserRole::find ()->orderBy ( 'label' )->asArray ()->all (), 'id', 'label' ),

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

											if (isset ( $model->userRole ) && ! empty ( $model->userRole->label ))

												return $model->userRole->label;

										} 

								],

								[ 

										'attribute' => 'status',

									//	'label' => 'Status',

										'filterType' => GridView::FILTER_SELECT2,

										'format' => 'raw',

										'width' => '150px',

										'filter' => $status,

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

											if($model->status != '10'){

												return '<span class="label label-danger">'.Yii::t('app', 'Inactive').'</span>';

											}else{

												return '<span class="label label-primary">'.Yii::t('app', 'Active').'</span>';

											}

										} 

								],

								

								// 'role',

								//'status',

								

								// 'created_at',

								// 'updated_at',

								

								[ 

										'class' => 'yii\grid\ActionColumn',

										'template'=>'{update} {view} {mail} {delete}',

										'buttons' => [ 

												'update' => function ($url, $model)

												{

													return Html::a ( '<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl ( [ 

															'user/user/update',

															'id' => $model->id,

															'edit' => 't' 

													] ), [ 

															'title' => Yii::t ( 'yii', 'Edit' ) 

													] );

												} ,

												'mail' => function($url,$model){

					 return '<a href="index.php?r=user/user/mail-compose&id='.$model->id.'" title="Mail"><span class="glyphicon glyphicon-envelope"></span></a>';

				},

											

												'delete' => function ($url, $model)

												{

													if($model->user_role_id =='1'){

														return '';

													}else{

													return Html::a ( '<span class="glyphicon glyphicon-trash"></span>', Yii::$app->urlManager->createUrl ( [ 

															'user/user/delete',

															'id' => $model->id

													] ), [ 

															'title' => Yii::t ( 'yii', 'Delete' ) ,
															'data-method'=>"post",
															'onclick'=>'return confirm("Are you Sure!")'

													] );

													}

												} 

										] 

								]

								 

						],

						'responsive' => true,

						'hover' => true,

						'condensed' => true,

						'floatHeader' => false,

						

						'panel' => [ 

								'heading' => '<i class="glyphicon glyphicon-th-list"></i> ' . Html::encode ( $this->title ),

								'type' => 'info',

								'before' => Html::a ( '<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add'), [ 

										'create' 

								], [ 

										'class' => 'btn btn-success' 

								] ),

								'after' => Html::a ( '<i class="glyphicon glyphicon-repeat"></i> '.Yii::t('app', 'Reset List'), [ 

										'index' 

								], [ 

										'class' => 'btn btn-info' 

								] ),

								'showFooter' => false 

						] 

				] );

				Pjax::end ();

				?>



</div>





