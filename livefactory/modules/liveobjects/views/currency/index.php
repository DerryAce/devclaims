<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var livefactory\models\search\Currency $searchModel
 */

$this->title = Yii::t('app', 'Claims Nature');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="currency-index">
    <!--<div class="page-header">
            <h1><?= Html::encode($this->title) ?></h1>
    </div>-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Currency',
]), ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',

								[ 

										'attribute' => 'currency',

										'label' => Yii::t('app', 'Currency'),

										'format' => 'raw',

										'width' => '50px',

										'value' => function ($model, $key, $index, $widget)

										{

														return' <a href="index.php?r=liveobjects%2Fcurrency%2Fupdate&id='.$model->id.'">'.$model->currency.'</a>';

										} 

								],
           // 'currency',
            'alphabetic_code',
            'numeric_code',
            'minor_unit',
//            'status', 
//            'added_at', 
//            'updated_at', 

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                'update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', Yii::$app->urlManager->createUrl(['liveobjects/currency/update','id' => $model->id]), [
                                                    'title' => Yii::t('yii', 'Edit'),
                                                  ]);},

					 'view' => function ($url, $model) {
                                    return '';}

                ],
            ],
        ],
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>true,




        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Yii::t('yii', Html::encode($this->title)).' </h3>',
            'type'=>'info',
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i>  '.Yii::t('app', 'Add'), ['create'], ['class' => 'btn btn-success']),                                                                                                                                                          'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> '.Yii::t('app', 'Reset List'), ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],
    ]); Pjax::end(); ?>

</div>
