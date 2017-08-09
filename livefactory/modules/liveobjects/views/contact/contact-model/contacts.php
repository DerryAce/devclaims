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

        'dataProvider' => $dataProviderContacts,

        //'filterModel' => $searchModelAttch,

        'columns' => [

            ['class' => 'yii\grid\SerialColumn'],



  //          'id',

            //'task_id',

            //'task_name',

			[ 

					'attribute' => 'first_name',

					'format' => 'raw'

			],

			[ 

					'attribute' => 'last_name'

			],

			[ 

					'attribute' => 'email'

			],

			[ 

					'attribute' => 'phone'

			],

			[ 

					'attribute' => 'mobile'

			],

			[ 

					'attribute' => 'fax'

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

                                    return"<form name='frm_contact".$model->id."' action='".'index.php?r='.$_REQUEST['r'].'&id='.$_REQUEST['id']."&contact_edit=".$model->id."' method='post' style='display:inline'><input type='hidden' value='$csrf' name='_csrf'>

									<a href='#' onClick='document.frm_contact".$model->id.".submit()' title='Edit' target='_parent'><span class='glyphicon glyphicon-pencil'></span></a></form>";},

				'delete' => function ($url, $model) {

                                    return '<a href="index.php?r='.$_REQUEST['r'].'&id='.$_REQUEST['id'].'&contact_del='.$model->id.'" onClick="return confirm(\'Are you Sure!\')" title="Delete"><span class="glyphicon glyphicon-trash"></span></a>';

									



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

            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Yii::t('app', 'Contacts').'</h3>',

            'type'=>'info',

            'before'=>'<a href="javascript:void(0)" class="btn btn-success btn-sm" onClick="$(\'.contactae\').modal(\'show\');"><i class="glyphicon glyphicon-phone"></i>'.Yii::t('app', 'New Contact').' </a>',          /*                                                                                                                                                'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),*/

            'showFooter'=>false

        ],

    ]); Pjax::end(); ?>