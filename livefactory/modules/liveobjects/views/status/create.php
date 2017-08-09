<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Status $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Status',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Statuses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="status-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
