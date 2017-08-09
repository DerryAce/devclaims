<?php



use yii\helpers\Html;



/**

 * @var yii\web\View $this

 * @var common\models\Defect $model

 */



$this->title = Yii::t('app', 'Report Defect');

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Defects'), 'url' => ['index']];

$this->params['breadcrumbs'][] = $this->title;

//echo Yii::t('app')->user->getId();

?>

<style>	

.cke_contents{max-height:250px}

</style>

<script src="../include/jquery.js"></script>

<script>

$(document).ready(function(e) {

   $('#defect-actual_start_datetime').val('0000-00-00 00:00:00'); 

   $('#defect-actual_end_datetime').val('0000-00-00 00:00:00'); 

   $('#defect-project_id').change(function(){

	  //alert('index.php?r=pmt/defect/ajax-project-users&project_id='+$(this).val());

	 $.post('index.php?r=pmt/defect/ajax-project-users&project_id='+$(this).val(),function(r){

		$('#defect-assigned_user_id').html(r) ;

	 })

   })

});

</script>





 <div class="ibox float-e-margins">

                    <div class="ibox-title">

                        <h5><?= Yii::t('app', "Report Defect") ?> <small class="m-l-sm"><?= Yii::t('app', "Enter Defect Name, Start Time, ETA & Description") ?></small></h5>

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

<div class="defect-create">

    <div class="page-header">

        <h1><?= Html::encode($this->title) ?></h1>

    </div>





</div>



<div class="panel panel-info">

	<div class="panel-heading">

    	<h3 class="panel-title"><?= Html::encode($this->title) ?></h3>

    </div>

    <div class="panel-body">

        <div class="defect-create">

            <?= $this->render('_form', [

                'model' => $model,

            ]) ?>

        

        </div>

	</div>

</div>

-->

