<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\Location $searchModel
 */

$this->title = 'Locations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div
	class="location-index">
	<!-- 
	<div class="page-header">
		<h1><?= Html::encode($this->title) ?></h1>
	</div>
	 -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Location', ['create'], ['class' => 'btn btn-sm btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

 //           'id',
            'location',
            'active',
            ['attribute'=>'date_added','filterType' => GridView::FILTER_DATE,'width' => '150px','filterWidgetOptions' => ['pluginOptions' => ['format' => 'd-m-Y']],'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],
            ['attribute'=>'date_modified','filterType' => GridView::FILTER_DATE,'width' => '150px','filterWidgetOptions' => ['pluginOptions' => ['format' => 'd-m-Y']],'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                'update' => function ($url, $model) {
                                    return Html::a('<span
		class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['location/view','id' => $model->id,'edit'=>'t']), [
                                                    'title' => Yii::t('yii', 'Edit'),
                                                  ]);}

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
		class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' =>
	'btn btn-sm btn-success'])." ".Html::a('<i
		class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-sm btn-info']),                                                                                                                                                          'after'=>'',
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>

</div>
