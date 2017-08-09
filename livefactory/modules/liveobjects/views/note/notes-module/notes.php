<?php



use yii\helpers\Html;

use kartik\grid\GridView;

use yii\widgets\Pjax;

use livefactory\models\User;

use yii\helpers\ArrayHelper;

?>

    <?php 

	 error_reporting(0);

	 Yii::$app->request->enableCsrfValidation = true;

    $csrf=$this->renderDynamic('return Yii::$app->request->csrfToken;');

	//$pageUrl='index.php?r='.$_REQUEST['r'].'&id='.$_REQUEST['id'];

	Pjax::begin(); echo GridView::widget([

        'dataProvider' => $dataProviderNotes,

        //'filterModel' => $searchModelNotes,

        'columns' => [

            ['class' => 'yii\grid\SerialColumn'],



  //          'id',

            //'task_id',

            //'task_name',

			[ 

					'attribute' => 'notes',

					'format' => 'raw',

					'width' => '60%' 

			],

			[ 

					'attribute' => 'added_at',

					'width' => '20%',

					'value' => function ($model, $key, $index, $widget) {

					if(isset($model->added_at)) 

						return date('jS \of F Y',$model->added_at);

					}  

					

					

			],

			

			

			 

			[ 

				'attribute' => 'user_id',

				'label' => Yii::t('app', 'User'),

				'filterType' => GridView::FILTER_SELECT2,

				'format' => 'raw',

				'width' => '10%',

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

               'class' => 'yii\grid\ActionColumn',

				//'template'=>'{view}{update}{delete}',

				//'class'=>'CButtonColumn',

				// 'class' => ActionColumn::className(),

				

    			'template'=>'{update} {view} {delete}',

                'buttons' => [

				'width' => '150px',

                'update' => function ($url, $model) {

                                   return "<form name='frm".$model->id."' action='".'index.php?r='.$_REQUEST['r'].'&id='.$_REQUEST['id']."&note_id=".$model->id."' method='post' style='display:inline'><input type='hidden' value='$csrf' name='_csrf'>

									<a href='#' onClick='document.frm".$model->id.".submit()' title='Edit' target='_parent'><span class='glyphicon glyphicon-pencil'></span></a></form>";},

				'view' => function ($url, $model) {

                                    return "";},

				'delete' => function ($url, $model) {
					return '<form action="index.php?r='.$_REQUEST['r'].'&id='.$_REQUEST['id'].'&note_del_id='.$model->id.'" method="post" id="n'.$model->id.'">
					<input type="hidden" value="'.$csrf.'" name="_csrf">
					<a href="javascript:void(0)" onClick="formSubmit(\'n'.$model->id.'\')" title="Delete"><span class="glyphicon glyphicon-trash"></span></a>
					</form>';
/*return Html::a ( '<span class="glyphicon glyphicon-trash"></span>', 'index.php?r='.$_REQUEST['r'].'&id='.$_REQUEST['id'].'&note_del_id='.$model->id, [ 

															'title' => Yii::t ( 'yii', 'Delete' ) ,
															'data-method'=>"post",
															'onclick'=>'return confirm("Are you Sure!")'

													] );*/

                                   /* return '<a href="'.$url.'&note_del_id='.$model->id.'" onClick="return confirm(\'Are you Sure!\')" title="Delete"></a>';*/}

				



                ],

            ],

        ],

        'responsive'=>true,

        'hover'=>true,

        'condensed'=>true,

        //'floatHeader'=>true,









        'panel' => [

            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Yii::t('app', 'Notes').'  </h3>',

            'type'=>'info',

            'before'=>'<a href="javascript:void(0)" class="btn btn-success btn-sm" onClick="$(\'.add-notes-modal\').modal(\'show\');"><i class="glyphicon glyphicon-comment"></i> '.Yii::t('app', 'New Note').' </a>',           /*                                                                                                                                               'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),*/

            'showFooter'=>false

        ],

    ]); Pjax::end(); ?>

<script>

	function formSubmit(id){

		var r = confirm("<?=Yii::t ('app','Are you Sure!')?>");

		if (r == true) {

			$('#'+id).submit()

		} else {

			

		}	

	}
	</script>