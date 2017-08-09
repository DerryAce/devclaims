<?php



use yii\helpers\Html;

use kartik\grid\GridView;

use yii\widgets\Pjax;

use livefactory\models\User;

use yii\helpers\ArrayHelper;

?>

    <?php 

	if($_SESSION['project_user_id'] ==Yii::$app->user->identity->id || Yii::$app->user->identity->user_role_id=='1'){

		$btn='<a href="javascript:void(0)" class="btn btn-success btn-sm" onClick="$(\'.exist_users\').modal(\'show\');"><i class="glyphicon glyphicon-user"></i> '.Yii::t('app', 'Add User').'</a>';

	}

	Pjax::begin(); echo GridView::widget([

        'dataProvider' => $dataProviderUser,

        //'filterModel' => $searchModelUser,

        'columns' => [

            ['class' => 'yii\grid\SerialColumn'],



  //          'id',

            //'task_id',

            //'task_name',

			

			

			 

			[ 

				'attribute' => 'user_id',

				'label' =>Yii::t('app', 'First Name') ,

				'filterType' => GridView::FILTER_SELECT2,

				'format' => 'raw',

				'width' => '25%',

				'filter' => ArrayHelper::map (User::find()->orderBy ( 'id' )->asArray ()->all (), 'id', 'first_name' ),

				'filterWidgetOptions' => [ 

						'options' => [ 

								'placeholder' => 'All...' 

						],

						'pluginOptions' => [ 

								'allowClear' => true 

						] 

				],

				'value' => function ($model, $key, $index, $widget) {

					//var_dump($model->user);

				if(isset($model->user) && !empty($model->user->first_name)) 

					return $model->user->first_name;

				} 

			],

			[ 

				'attribute' => 'user_id',

				'label' => Yii::t('app', 'Last Name'),

				'filterType' => GridView::FILTER_SELECT2,

				'format' => 'raw',

				'width' => '25%',

				'filter' => ArrayHelper::map (User::find()->orderBy ( 'id' )->asArray ()->all (), 'id', 'first_name' ),

				'filterWidgetOptions' => [ 

						'options' => [ 

								'placeholder' => 'All...' 

						],

						'pluginOptions' => [ 

								'allowClear' => true 

						] 

				],

				'value' => function ($model, $key, $index, $widget) {

					//var_dump($model->user);

				if(isset($model->user) && !empty($model->user->first_name)) 

					return $model->user->last_name;

				} 

			],

			[ 

				'attribute' => 'user_id',

				'label' => Yii::t('app', 'Username'),

				'filterType' => GridView::FILTER_SELECT2,

				'format' => 'raw',

				'width' => '25%',

				'filter' => ArrayHelper::map (User::find()->orderBy ( 'id' )->asArray ()->all (), 'id', 'first_name' ),

				'filterWidgetOptions' => [ 

						'options' => [ 

								'placeholder' => 'All...' 

						],

						'pluginOptions' => [ 

								'allowClear' => true 

						] 

				],

				'value' => function ($model, $key, $index, $widget) {

					//var_dump($model->user);

				if(isset($model->user) && !empty($model->user->first_name)) 

					return $model->user->username;

				} 

			],

			[ 

					'attribute' => 'date_added',

					'width' => '20%'  ,

					'value' => function ($model, $key, $index, $widget) {

					if(isset($model->date_added)) {

						if($model->date_added=='0000-00-00 00:00:00'){

							return '<i>not set</i>';

						}else{

						return date('jS \of M Y H:i:s',strtotime($model->date_added));

							}

						}

										}

			],

			[ 



										'class' => 'yii\grid\ActionColumn',



										'template' => '{update} {view} {delete}',



										'buttons' => [ 



												'update' => function ($url, $model)

													{

													return '';

												},



												'view' => function ($url, $model)

													{

													return '';

												},

												'delete' => function ($url, $model)



												{

												if($_SESSION['project_user_id'] ==Yii::$app->user->identity->id || Yii::$app->user->identity->user_role_id=='1'){

													return Html::a ( '<span class="glyphicon glyphicon-trash"></span>', Yii::$app->urlManager->createUrl ( [ 



															'pmt/project/project-view',



															'id' => $_GET['id'],'udel'=>$model->id 



													] ), [ 



															'title' => Yii::t ( 'yii', 'Delete' ) ,

															'onClick'=>"return confirm('Are you Sure!')"



													] );

												}else{

													return '';	

												}



												}



										]



										 



								] 



        ],

        'responsive'=>true,

        'hover'=>true,

        'condensed'=>true,

        //'floatHeader'=>true,









        'panel' => [

            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Yii::t('app', 'Users').'</h3>',

            'type'=>'info',

            'before'=>$btn,                                                                                                                                                 /*         'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),*/

            'showFooter'=>false

        ],

    ]); Pjax::end(); ?>