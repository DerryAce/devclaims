<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\EmployeeType $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Employee Type',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Employee Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-type-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
