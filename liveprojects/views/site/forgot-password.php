<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Forgot';
$this->params['breadcrumbs'][] = $this->title;
?>
<body class="gray-bg">
<div class="middle-box text-center loginscreen  animated fadeInDown">

        <div>
            <div>
                <h1 class="logo-name"><?= Html::encode("Live") ?></h1>
            </div>
            <!--<h3>Welcome to LiveCRM</h3>-->
            <?php if($error){?>
				<div class="alert alert-danger" role="alert"><?=$error?></div>
			<?php }	?>
            <?php if($msg){?>
				<div class="alert alert-success" role="alert"><?=$msg?></div>
			<?php }	?>
            <p>Please fill out your username(email):</p>
            <?php $form = ActiveForm::begin(['id' => 'forgot-form', 'class' => 'm-t']); ?>

	
                <?= $form->field($model, 'email') ?>
                <?= Html::submitButton('Send', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
		

            <?php ActiveForm::end(); ?>
            <p class="m-t"> <small>&copy; 2017 Uib CRM | For KPLC Incident Management.</small> </p>
        </div>
</div>
