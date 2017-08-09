<?php

error_reporting(0);

use yii\helpers\Html;

use kartik\grid\GridView;

use yii\widgets\Pjax;

use livefactory\models\User;

use livefactory\models\FileModel;

use yii\helpers\ArrayHelper;

?>

    <?php 

	 if(file_exists("../attachments/".$entity_type."_".$_GET['id'].".zip")){

    	$zipbutton='<a href="../attachments/'.$entity_type.'_'.$_GET['id'].'.zip" class="btn btn-success btn-sm"><span class="fa fa-download"></span>'.Yii::t('app', 'Download All').' </a>';

	  unlink("../attachments/".$entity_type."_".$_GET['id'].".zip");

	  }

	 Yii::$app->request->enableCsrfValidation = true;

    $csrf=$this->renderDynamic('return Yii::$app->request->csrfToken;');

	Pjax::begin(); echo GridView::widget([

        'dataProvider' => $dataProviderAttach,

        //'filterModel' => $searchModelAttch,

        'columns' => [

            ['class' => 'yii\grid\SerialColumn'],



  //          'id',

            //'task_id',

            //'task_name',

			[ 

					'attribute' => 'file_title',

					'width' => '20%',

					'format' => 'raw',

					'value' => function ($model, $key, $index, $widget) {

                                    return "

									<form name='frmatts".$model->id."' action='../attachments/".$model->id.strrchr($model->file_name, ".")."' method='post' style='display:inline' target='_blank'>

									<a href='#' onClick='document.frmatts".$model->id.".submit()' title='View' target='_parent'>".$model->file_title."</a></form>";}, 

			],

			[ 

					'attribute' => 'file_name',

					'width' => '20%' 

			],

			/*[ 

					'attribute' => 'entity_type',

					'width' => '20%' 

			],*/

			

			

			 

			[ 

				'attribute' => 'uploaded_user_id',

				'label' => Yii::t('app', 'Added By'),

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

					'attribute' => 'updated_at',

					'label'=>Yii::t('app', 'Updated'),

					'width' => '25%' ,

					'value' => function ($model, $key, $index, $widget) {

					if($model->updated_at !='0') {

						if(strlen($model->updated_at) >4){

							return date('jS \of F Y',$model->updated_at);

						}else{

							return $model->updated_at;

						}

					} else{

						return 'not set';	

					}

				}

			],

            [

               'class' => 'yii\grid\ActionColumn',

				//'template'=>'{view}{update}{delete}',

				//'class'=>'CButtonColumn',

				// 'class' => ActionColumn::className(),

    			'template'=>'{update} {view} {mail} {delete}',

                'buttons' => [

				'width' => '100px',

                'update' => function ($url, $model) {

                                    return"<form name='frm_att".$model->id."' action='".'index.php?r='.$_REQUEST['r'].'&id='.$_REQUEST['id']."&attach_update=".$model->id."' method='post' style='display:inline'><input type='hidden' value='$csrf' name='_csrf'>

									<a href='#' onClick='document.frm_att".$model->id.".submit()' title='Edit' target='_parent'><span class='glyphicon glyphicon-pencil'></span></a></form>";},

				'view' => function ($url, $model) {

							if(strrchr($model->file_name, ".")=='.php'){

								return "

									<form name='frm".$model->id."' action='../attachments/view_attachment.php?pagename=".$model->id.strrchr($model->file_name, ".")."' method='post' style='display:inline' target='_blank'>

									<a href='#' onClick='document.frm".$model->id.".submit()' title='View' target='_parent'><span class='glyphicon glyphicon-eye-open'></span></a></form>";

								

							}else{

                                    return "

									<form name='frm".$model->id."' action='../attachments/".$model->id.strrchr($model->file_name, ".")."' method='post' style='display:inline' target='_blank'>

									<a href='#' onClick='document.frm".$model->id.".submit()' title='View' target='_parent'><span class='glyphicon glyphicon-eye-open'></span></a></form>";

					}

				},

				'mail' => function($url,$model){

					 return '<a href="javascript:void(0)" onClick="sendAttachment(\''.$model->file_name.'\',\''.$model->id.strrchr($model->file_name, ".").'\')" title="Mail"><span class="glyphicon glyphicon-envelope"></span></a>';

				},

				'delete' => function ($url, $model) {
					return '<form action="index.php?r='.$_REQUEST['r'].'&id='.$_REQUEST['id'].'&attachment_del_id='.$model->id.'" method="post" id="n'.$model->id.'">
					<input type="hidden" value="'.$csrf.'" name="_csrf">
					<a href="javascript:void(0)" onClick="formSubmit(\'n'.$model->id.'\')" title="Delete"><span class="glyphicon glyphicon-trash"></span></a>
					</form>';
/*return Html::a ( '<span class="glyphicon glyphicon-trash"></span>', Yii::$app->urlManager->createUrl ( [ 

															'attachment_del_id',

															'id' => $model->id

													] ), [ 

															'title' => Yii::t ( 'yii', 'Delete' ) ,
															'data-method'=>"post",
															'onclick'=>'return confirm("Are you Sure!")'

													] );*/

                                   /* return '<a href="index.php?r=pmt/task%2Ftask-view&id='.$_REQUEST['id'].'&attachment_del_id='.$model->id.'" onClick="return confirm(\'Are you Sure!\')" title="Delete"><span class="glyphicon glyphicon-trash"></span></a>';*/

									

									/* Html::a(' <span class="glyphicon glyphicon-trash danger"></span>', Yii::$app->urlManager->createUrl(['task/task-view','id'=>$_REQUEST['id'],'attachment_id' => $model->id]), [

                                                    'title' => Yii::t('yii', 'Delete'),

                                                  ]);*/
												  }

				



                ],

            ],

        ],

        'responsive'=>true,

        'hover'=>true,

        'condensed'=>true,

        //'floatHeader'=>true,









        'panel' => [

            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Yii::t('app', 'Attachments').'  </h3>',

            'type'=>'info',

            'before'=>'<a href="javascript:void(0)" class="btn btn-success btn-sm" onClick="$(\'.savepopup\').modal(\'show\');"><i class="glyphicon glyphicon-save"></i> '.Yii::t('app', 'New Attachment').'  </a> '.$zipbutton,          /*                                                                                                                                                'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),*/

            'showFooter'=>false

        ],

    ]); Pjax::end(); 

	

	  

	foreach(FileModel::getAttachmentFiles($entity_type,$_GET['id']) as $row){

		$attachment_files[]="../attachments/".$row['id'].strrchr($row['file_name'], ".");

	}

	function create_zip($files = array(),$destination = '',$overwrite = false) {

			//if the zip file already exists and overwrite is false, return false

			if(file_exists($destination) && !$overwrite) { return false; }

			//vars

			$valid_files = array();

			//if files were passed in...

			if(is_array($files)) {

				//cycle through each file

				foreach($files as $file) {

					//make sure the file exists

					if(file_exists($file)) {

						$valid_files[] = $file;

					}

				}

			}

			//if we have good files...

			if(count($valid_files)) {

				//create the archive

				$zip = new \ZipArchive();

				if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {

					return false;

				}

				//add the files

				foreach($valid_files as $file) {

					$zip->addFile($file,$file);

				}

				//debug

				//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;

				

				//close the zip -- done!

				$zip->close();

				

				//check to make sure the file exists

				return file_exists($destination);

			}

			else

			{

				return false;

			}

		}

	$fileModel = new FileModel();

	create_zip($attachment_files,"../attachments/".$entity_type."_".$_GET['id'].".zip");

	?>
	<script>

	function formSubmit(id){

		var r = confirm("<?=Yii::t ('app','Are you Sure!')?>");

		if (r == true) {

			$('#'+id).submit()

		} else {

			

		}	

	}
	</script>