<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var livefactory\models\ConfigItem $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Config Item',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Config Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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

