<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\File $model
 */

$this->title = 'Upload Audio';
$this->params['breadcrumbs'][] = ['label' => 'Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form_audio', [
        'model' => $model,
    ]) ?>

</div>
