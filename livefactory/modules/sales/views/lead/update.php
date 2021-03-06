<?php



use yii\helpers\Html;



/**

 * @var yii\web\View $this

 * @var livefactory\models\Lead $model

 */



$this->title = Yii::t('app', 'Update Lead') . ' ' . $model->id;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Leads'), 'url' => ['index']];

$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];

$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

?>

<div class="lead-update">



    <h1><?= Html::encode($this->title) ?></h1>



    <?= $this->render('_form', [

        'model' => $model,

    ]) ?>



</div>

