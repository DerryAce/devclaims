<?php



use yii\helpers\Html;

use kartik\detail\DetailView;

use kartik\datecontrol\DateControl;



/**

 * @var yii\web\View $this

 * @var common\models\File $model

 */



$this->title = $model->file_title;

$this->params['breadcrumbs'][] = ['label' => 'Files', 'url' => ['index']];

$this->params['breadcrumbs'][] = $this->title;

?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/js/bootstrap.min.js', ['depends' => [yii\web\YiiAsset::className()]]);?>

<div class="file-view">

   <!--  <div class="page-header">

        <h1><?= Html::encode($this->title) ?></h1>

    </div> -->

	

	

	<center><EMBED src="<?php echo $model->file_path; ?>" WIDTH="100%" HEIGHT="1000px" AUTOPLAY="TRUE" LOOP="true"></EMBED></center>



	<br/>

	

    <?= DetailView::widget([

            'model' => $model,

            'condensed'=>true,

            'hover'=>true,

            'mode'=>Yii::$app->request->get('edit')=='t' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,

            'panel'=>[

            'heading'=>$this->title,

            'type'=>DetailView::TYPE_INFO,

        ],

        'attributes' => [

        //    'id',

        //    'file_name',

        //   'file_title',

        //    'file_path',

            'file_type',

            'file_size',

        //    'user_type',

        

            [

                'attribute'=>'date_added',

                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],

                'type'=>DetailView::INPUT_WIDGET,

                'widgetOptions'=> [

                    'class'=>DateControl::classname(),

                    'type'=>DateControl::FORMAT_DATETIME

                ]

            ],

            [

                'attribute'=>'date_modified',

                'format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A'],

                'type'=>DetailView::INPUT_WIDGET,

                'widgetOptions'=> [

                    'class'=>DateControl::classname(),

                    'type'=>DateControl::FORMAT_DATETIME

                ]

            ],

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

