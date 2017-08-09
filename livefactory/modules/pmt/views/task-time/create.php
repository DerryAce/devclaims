<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\TaskTime $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Task Time',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Task Times'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-time-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
