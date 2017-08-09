<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\File $model
 */

$this->title = 'Upload Video';
$this->params['breadcrumbs'][] = ['label' => 'Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form_video', [
        'model' => $model,
    ]) ?>

</div>
