<?php



use yii\helpers\Html;

use kartik\detail\DetailView;

use kartik\datecontrol\DateControl;



/**

 * @var yii\web\View $this

 * @var livefactory\models\Contact $model

 */



$this->title = $model->id;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contacts'), 'url' => ['index']];

$this->params['breadcrumbs'][] = $this->title;

?>
<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/js/bootstrap.min.js', ['depends' => [yii\web\YiiAsset::className()]]);?>

<div class="contact-view">

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

            'first_name',

            'middle_name',

            'last_name',

            'email:email',

            'phone',

            'mobile',

            'fax',

            'entity_type',

            'entity_id',

            'created_at',

            'updated_at',

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

