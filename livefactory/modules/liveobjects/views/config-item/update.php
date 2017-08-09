<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var livefactory\models\ConfigItem $model
 */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Config Item',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Config Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>

<div class="panel panel-info">
	<div class="panel-heading">
    	<h3 class="panel-title"><?= Html::encode($this->title) ?> </h3>
    </div>
    <div class="panel-body">
    	  <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
</div>

<!--
<div class="config-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
-->