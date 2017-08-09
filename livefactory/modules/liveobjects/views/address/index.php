<?php



use yii\helpers\Html;

use kartik\grid\GridView;

use yii\widgets\Pjax;

use livefactory\models\Country;

use livefactory\models\State;

use livefactory\models\City;

use yii\helpers\ArrayHelper;



/**

 *

 * @var yii\web\View $this

 * @var yii\data\ActiveDataProvider $dataProvider

 * @var livefactory\models\search\Address $searchModel

 */



$this->title = Yii::t ( 'app', 'Addresses' );

$this->params ['breadcrumbs'] [] = $this->title;
//var_dump();
?>
<div class="address-index">
<!--
	<div class="page-header">
		<h1><?= Html::encode($this->title) ?></h1>
	</div>
	-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!--<p> -->
        <?php 

/*

				       * echo Html::a(Yii::t('app', 'Create {modelClass}', [

				       * 'modelClass' => 'Address',

				       * ]), ['create'], ['class' => 'btn btn-success'])

				       */

								?>
  <!--  </p> -->

    <?php

			if(!empty($_REQUEST['Address']["country_id"])){
									$c_id=$_REQUEST['Address']["country_id"];
									$states=ArrayHelper::map ( State::find ()->orderBy ( 'state' )->asArray ()->where("country_id=$c_id")->all (), 'id', 'state' );
								}else{
									$states=ArrayHelper::map ( State::find ()->orderBy ( 'state' )->asArray ()->where("id=0")->all (), 'id', 'state' );
								}	
			if(!empty($_REQUEST['Address']["state_id"])){
									$s_id=$_REQUEST['Address']["state_id"];
									$cities=ArrayHelper::map ( City::find ()->orderBy ( 'city' )->asArray ()->where("state_id=$s_id")->all (), 'id', 'city' );
								}else{
									$cities=ArrayHelper::map ( City::find ()->orderBy ( 'city' )->asArray ()->where("id=0")->all (), 'id', 'city' );
								}	

Pjax::begin ();

				echo GridView::widget ( [ 

						'dataProvider' => $dataProvider,

						'filterModel' => $searchModel,

						'columns' => [ 

								[ 

										'class' => 'yii\grid\SerialColumn' 

								],

								

								// 'id',

								'address_1',

								'address_2',

								[ 

										'attribute' => 'country_id',

										//'label' => 'Country',

										'filterType' => GridView::FILTER_SELECT2,

										'format' => 'raw',

										'width' => '150px',

										'filter' => ArrayHelper::map ( Country::find ()->orderBy ( 'country' )->asArray ()->all (), 'id', 'country' ),

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

											if (isset ( $model->country ) && ! empty ( $model->country->country ))

												return $model->country->country;

										} 

								],

								

								[ 

										'attribute' => 'state_id',

										//'label' => 'State',

										'filterType' => GridView::FILTER_SELECT2,

										'format' => 'raw',

										'width' => '150px',

										'filter' => $states,

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

											if (isset ( $model->state ) && ! empty ( $model->state->state ))

												return $model->state->state;

										} 

								],

								

								[ 

										'attribute' => 'city_id',

										//'label' => 'City',

										

										'filterType' => GridView::FILTER_SELECT2,

										'format' => 'raw',

										'width' => '150px',

										

										 'filter' => $cities,

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

											if (isset ( $model->city ) && ! empty ( $model->city->city ))

												return $model->city->city;

										} 

								],

								

								'zipcode',

								

								// 'created_at',

								// 'updated_at',

								

								[ 

										'class' => 'yii\grid\ActionColumn',

										'template' => '{view} {update} {delete}',

										'buttons' => [ 

												'update' => function ($url, $model)

												{

													return Html::a ( '<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl ( [ 

															'liveobjects/address/update',

															'id' => $model->id,

															'edit' => 't' 

													] ), [ 

															'title' => Yii::t ( 'yii', 'Edit' ) 

													] );

												} 

										]

										 

								] 

						],

						'responsive' => true,

						'hover' => true,

						'condensed' => true,

						'floatHeader' => false,

						

						'panel' => [ 

								'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> ' . Html::encode ( $this->title ) . ' </h3>',

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
