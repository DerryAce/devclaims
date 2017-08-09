<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\File $searchModel
 */

$this->title = 'Files';
$this->params['breadcrumbs'][] = $this->title;
?>
<div
	class="file-index">
	<!-- 
	<div class="page-header">
		<h1><?= Html::encode($this->title) ?></h1>
	</div>
	 -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create File', ['create'], ['class' => 'btn btn-sm btn-success'])*/  ?>
    </p>



    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
					
   //         'id',
   
    		[
    		'attribute' => 'file_path',
    		'label' => 'File',
    		'filter' => false,
    		'format' => 'raw',
    		//'width' => '60px',
    		'value' => function ($model, $key, $index, $widget) {
    		
    			return Html::a( '<EMBED src="'.$model->file_path.'" WIDTH="200"  AUTOPLAY="FALSE" LOOP="false"></EMBED>', Yii::$app->getUrlManager()->createUrl(['file/view', 'id' => $model->id]), [
    					'title' => 'View',
    				//	'data-toggle' => "modal",
    				//	'data-target'=> ".bs-example-modal-lg"
    					] );
    		}
    		],
    		
    		'file_title',
            //'file_name',
            
           
    		
    		
    		
    		
            'file_type',
//            'file_size', 
//            'user_type', 
//            ['attribute'=>'date_added','filterType' => GridView::FILTER_DATE,'width' => '150px','filterWidgetOptions' => ['pluginOptions' => ['format' => 'd-m-Y']],'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 
//            ['attribute'=>'date_modified','filterType' => GridView::FILTER_DATE,'width' => '150px','filterWidgetOptions' => ['pluginOptions' => ['format' => 'd-m-Y']],'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']], 

            [
                'class' => 'kartik\grid\ActionColumn',
                'buttons' => [
                /*
                'update' => function ($url, $model) {
                                    return Html::a('<span
														class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['file/view','id' => $model->id,'edit'=>'t']), [
                                                    'title' => Yii::t('yii', 'Edit'),
                                                  ]);}*/

                ],
            ],
        ],
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>false,



        'panel' => [
            'heading'=>'<h3 class="panel-title">
		<i class="glyphicon glyphicon-th-list"></i>
		'.Html::encode($this->title).'
	</h3>
	', 'type'=>'default', 'before'=>Html::a('<i
		class="glyphicon glyphicon-upload"></i> Upload Image', ['createimage'], ['class' =>
		'btn btn-sm btn-success'])." ".Html::a('<i
		class="glyphicon glyphicon-upload"></i> Upload Video', ['createvideo'], ['class' =>
		'btn btn-sm btn-success'])." ".Html::a('<i
		class="glyphicon glyphicon-upload"></i> Upload Audio', ['createaudio'], ['class' =>
		'btn btn-sm btn-success'])." ".Html::a('<i
		class="glyphicon glyphicon-upload"></i> Upload File', ['createfile'], ['class' =>
		'btn btn-sm btn-success'])." ".Html::a('<i
		class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-sm btn-info']),                                                                                                                                                          'after'=>'',
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>
    


</div>

