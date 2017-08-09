<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Employee $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Employee',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Employees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
