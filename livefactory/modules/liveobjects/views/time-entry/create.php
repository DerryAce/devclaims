<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var livefactory\models\TimeEntry $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Time Entry',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Time Entries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="time-entry-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
