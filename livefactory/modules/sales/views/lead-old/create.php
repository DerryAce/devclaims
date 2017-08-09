<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var livefactory\models\Lead $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Lead',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Leads'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>	
.cke_contents{max-height:250px}
</style>
<script src="../include/jquery.js"></script>
<script>
$(document).ready(function(e) {
   $('#lead-actual_start_datetime').val('0000-00-00 00:00:00'); 
   $('#lead-actual_end_datetime').val('0000-00-00 00:00:00'); 
  /* $('#lead-project_id').change(function(){
	  //alert('index.php?r=pmt/task/ajax-project-users&project_id='+$(this).val());
	 $.post('index.php?r=pmt/task/ajax-project-users&project_id='+$(this).val(),function(r){
		$('#lead-assigned_user_id').html(r) ;
	 })
   })*/
});
</script>
<div class="lead-create">
    <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?= Html::encode("Lead Details") ?> <small class="m-l-sm">Enter Lead Name, Start Time, ETA & Description</small></h5>
                        <div class="ibox-tools">
						    <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div></div></div>
