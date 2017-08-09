<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\search\Config $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="config-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'setting_key') ?>

    <?= $form->field($model, 'setting_group') ?>

    <?= $form->field($model, 'setting_label') ?>

    <?= $form->field($model, 'setting_type') ?>

    <?php // echo $form->field($model, 'setting_value') ?>

    <?php // echo $form->field($model, 'setting_options') ?>

    <?php // echo $form->field($model, 'setting_weight') ?>

    <?php // echo $form->field($model, 'setting_description') ?>

    <?php // echo $form->field($model, 'active') ?>

    <?php // echo $form->field($model, 'date_added') ?>

    <?php // echo $form->field($model, 'date_modified') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
