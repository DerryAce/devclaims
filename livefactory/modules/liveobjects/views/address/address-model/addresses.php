<?php



use yii\helpers\Html;

use kartik\grid\GridView;

use yii\widgets\Pjax;

use livefactory\models\Country;

use livefactory\models\State;

use livefactory\models\City;

use yii\helpers\ArrayHelper;

?>

    <?php 

	 Yii::$app->request->enableCsrfValidation = true;

    $csrf=$this->renderDynamic('return Yii::$app->request->csrfToken;');

	Pjax::begin(); echo GridView::widget([

        'dataProvider' => $dataProviderAddresses,

        //'filterModel' => $searchModelAttch,

        'columns' => [

            ['class' => 'yii\grid\SerialColumn'],



  //          'id',

            //'task_id',

            //'task_name',

			[ 

					'attribute' => 'address_1',
					'label'=>Yii::t('app', 'Address 1'),

					'width' => '20%',

					'format' => 'raw'

			],

			[ 

					'attribute' => 'zipcode',
					'label'=>Yii::t('app', 'Zipcode'),

					'width' => '20%' 

			],

			/*[ 

					'attribute' => 'entity_type',

					'width' => '20%' 

			],*/

			

			

			 

			[ 

				'attribute' => 'country_id',
					'label'=>Yii::t('app', 'Country'),

				'filterType' => GridView::FILTER_SELECT2,

				'format' => 'raw',

				'width' => '25%',

				'value' => function ($model, $key, $index, $widget) {

					//var_dump($model->user);

				if(isset($model->country) && !empty($model->country->country)) 

					return $model->country->country;

				} 

		],

		[ 

				'attribute' => 'state_id',
				'label'=>Yii::t('app', 'State'),

				'filterType' => GridView::FILTER_SELECT2,

				'format' => 'raw',

				'width' => '25%',

				'value' => function ($model, $key, $index, $widget) {

					//var_dump($model->user);

				if(isset($model->state) && !empty($model->state->state)) 

					return $model->state->state;

				} 

		],

		[ 

				'attribute' => 'city_id',
				'label'=>Yii::t('app', 'City'),

				'filterType' => GridView::FILTER_SELECT2,

				'format' => 'raw',

				'width' => '25%',

				'value' => function ($model, $key, $index, $widget) {

					//var_dump($model->user);

				if(isset($model->city) && !empty($model->city->city)) 

					return $model->city->city;

				} 

		],

            [

               'class' => 'yii\grid\ActionColumn',

				//'template'=>'{view}{update}{delete}',

				//'class'=>'CButtonColumn',

				// 'class' => ActionColumn::className(),

    			'template'=>'{update}  {delete}',

                'buttons' => [

				'width' => '100px',

                'update' => function ($url, $model) {

                                    return"<form name='frm_address".$model->id."' action='".'index.php?r='.$_REQUEST['r'].'&id='.$_REQUEST['id']."&address_edit=".$model->id."' method='post' style='display:inline'><input type='hidden' value='$csrf' name='_csrf'>

									<a href='#' onClick='document.frm_address".$model->id.".submit()' title='Edit' target='_parent'><span class='glyphicon glyphicon-pencil'></span></a></form>";},

				'delete' => function ($url, $model) {

                                    return '<a href="index.php?r='.$_REQUEST['r'].'&id='.$_REQUEST['id'].'&address_del='.$model->id.'" onClick="return confirm(\'Are you Sure!\')" title="Delete"><span class="glyphicon glyphicon-trash"></span></a>';

									



									/* Html::a(' <span class="glyphicon glyphicon-trash danger"></span>', Yii::$app->urlManager->createUrl(['task/task-view','id'=>$_REQUEST['id'],'attachment_id' => $model->id]), [

                                                    'title' => Yii::t('yii', 'Delete'),

                                                  ]);*/}

				



                ],

            ],

        ],

        'responsive'=>true,

        'hover'=>true,

        'condensed'=>true,

        //'floatHeader'=>true,









        'panel' => [

            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Yii::t('app', 'Addresses').'  </h3>',

            'type'=>'info',

            'before'=>'<a href="javascript:void(0)" class="btn btn-success btn-sm" onClick="$(\'.addressae\').modal(\'show\');"><i class="glyphicon glyphicon-road"></i> '.Yii::t('app', 'New Address').'</a>',  
			        /*                                                                                                                                                'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),*/

            'showFooter'=>false

        ],

    ]); Pjax::end(); ?>