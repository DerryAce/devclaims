<?php



use yii\helpers\Html;

use kartik\grid\GridView;

use yii\widgets\Pjax;

use livefactory\models\Country;

use yii\helpers\ArrayHelper;



/**

 *

 * @var yii\web\View $this

 * @var yii\data\ActiveDataProvider $dataProvider

 * @var livefactory\models\search\State $searchModel

 */



$this->title = Yii::t ( 'app', 'States' );

$this->params ['breadcrumbs'] [] = $this->title;

function statusLabel($status)

{

	if ($status !='1')

	{

		$label = "<span class=\"label label-danger\">".Yii::t('app', 'Inactive')."</span>";

	}

	else

	{

		$label = "<span class=\"label label-primary\">".Yii::t('app', 'Active')."</span>";

	}

	return $label;

}

$status = array('0'=>Yii::t('app', 'Inactive'),'1'=>Yii::t('app', 'Active'));

?>

<div class="state-index">

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

				       * 'modelClass' => 'State',

				       * ]), ['create'], ['class' => 'btn btn-success'])

				       */

								?>

    <!--</p> -->



    <?php

				

Pjax::begin ();

				echo GridView::widget ( [ 

						'dataProvider' => $dataProvider,

						'filterModel' => $searchModel,

						'columns' => [ 

								[ 

										'class' => 'yii\grid\SerialColumn' 

								],

								

								// 'id',

								'state',

								'state_code',

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

								//'active',

								[ 

										'attribute' => 'active',

										//'label' => 'Active',

										'format' => 'raw',

										'filterType' => GridView::FILTER_SELECT2,

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

												return statusLabel ( $model->active );

										} 

								],

								

								// 'added_at',

								// 'updated_at',

								

								[ 

										'class' => 'yii\grid\ActionColumn',

										'buttons' => [ 

												'update' => function ($url, $model)

												{

													return Html::a ( '<span class="glyphicon glyphicon-eye-open"></span>', Yii::$app->urlManager->createUrl ( [ 

															'liveobjects/state/view',

															'id' => $model->id,

															'edit' => 't' 

													] ), [ 

															'title' => Yii::t ( 'yii', 'Edit' ) 

													] );

												} ,
												'view' => function ($url, $model)

												{

													return '';

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

