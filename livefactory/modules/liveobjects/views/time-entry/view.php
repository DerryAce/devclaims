<?php



use yii\helpers\Html;

use kartik\detail\DetailView;

use kartik\datecontrol\DateControl;



/**

 * @var yii\web\View $this

 * @var livefactory\models\TimeEntry $model

 */



$this->title = $model->id;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Time Entries'), 'url' => ['index']];

$this->params['breadcrumbs'][] = $this->title;

?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/js/bootstrap.min.js', ['depends' => [yii\web\YiiAsset::className()]]);?>

<div class="time-entry-view">

    <div class="page-header">

        <h1><?= Html::encode($this->title) ?></h1>

    </div>





    <?= DetailView::widget([

            'model' => $model,

            'condensed'=>false,

            'hover'=>true,

            'mode'=>Yii::$app->request->get('edit')=='t' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,

            'panel'=>[

            'heading'=>$this->title,

            'type'=>DetailView::TYPE_INFO,

        ],

        'attributes' => [

            'id',

            [

                'attribute'=>'start_time',

                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],

                'type'=>DetailView::INPUT_WIDGET,

                'widgetOptions'=> [

                    'class'=>DateControl::classname(),

                    'type'=>DateControl::FORMAT_DATETIME

                ]

            ],

            [

                'attribute'=>'end_time',

                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],

                'type'=>DetailView::INPUT_WIDGET,

                'widgetOptions'=> [

                    'class'=>DateControl::classname(),

                    'type'=>DateControl::FORMAT_DATETIME

                ]

            ],

            'entity_id',

            'entity_type',

            'user_id',

            'entry_type',

            'added_at',

            'modified_by_user_id',

            'modified_at',

            'notes',

            'approved',

        ],

        'deleteOptions'=>[

        'url'=>['delete', 'id' => $model->id],

        'data'=>[

        'confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'),

        'method'=>'post',

        ],

        ],

        'enableEditMode'=>false,

    ]) ?>



</div>

