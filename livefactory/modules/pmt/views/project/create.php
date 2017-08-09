<?php



use yii\helpers\Html;



/**

 * @var yii\web\View $this

 * @var common\models\Project $model

 */



$this->title = Yii::t('app', 'Create Claim');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Claims'), 'url' => ['index']];

$this->params['breadcrumbs'][] = $this->title;

?>

<script src="../include/jquery.js"></script>

<style>	

.cke_contents{max-height:250px}

</style>

<script>

$(document).ready(function(e) {

CKEDITOR.config.autoParagraph = false;

    $('#project-customer_id').after('<a href="index.php?r=customer/customer/create" class="btn btn-xs btn-info"><span class="glyphicon glyphicon-plus"></span> <?= Yii::t('app', "Add New") ?> </a>');

	$('#project-customer_id').css({'float':'left'});
	if('<?=!empty($_GET['customer_id'])?$_GET['customer_id']:''?>' !='')
	$('.field-project-customer_id').parent().hide();

});

</script>



                <div class="ibox float-e-margins">

                    <div class="ibox-title">

                        <h5><?= Yii::t('app', "Claim Details") ?> <small class="m-l-sm"><?= Yii::t('app', "Enter Claim Details & Description") ?></small></h5>

                        <div class="ibox-tools">

						    <a class="collapse-link">

                                <i class="fa fa-chevron-up"></i>

                            </a>

							<!--

                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">

                                <i class="fa fa-wrench"></i>

                            </a>

							

                            <ul class="dropdown-menu dropdown-user">

                                <li><a href="#">Config option 1</a>

                                </li>

                                <li><a href="#">Config option 2</a>

                                </li>

                            </ul>

							-->

                            <a class="close-link">

                                <i class="fa fa-times"></i>

                            </a>

                        </div>

                    </div>

                    <div class="ibox-content">

										 <div class="project-create">

							<?= $this->render('_form', [

								'model' => $model,

							]) ?>

						

						</div>

                    </div>

                </div>



<!--

<div class="project-create">

    <div class="page-header">

        <h1><?= Html::encode($this->title) ?></h1>

    </div>

</div>

-->



<!--

<div class="panel panel-primary">

	<div class="panel-heading">

    	<h3 class="panel-title"><?= Html::encode($this->title) ?>

        </h3>

    </div>

    <div class="panel-body">

        <div class="project-create">

            <?= $this->render('_form', [

                'model' => $model,

            ]) ?>

        

        </div>

    </div>

</div>

-->