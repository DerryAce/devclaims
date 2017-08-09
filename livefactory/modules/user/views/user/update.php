<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\User $model
 */

$this->title = Yii::t('app', 'Update User').' : ' . ' ' . $model->first_name." ".$model->last_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->first_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<script src="../include/jquery.js"></script>
<script type="text/javascript"> 
$(document).ready(function(){
	//$('.ddddd').modal('show');
	if('<?=!empty($new_password)?$new_password:''?>' !=''){
	//	$('.msg').modal('show');
	alert("New password is :"+'<?=!empty($new_password)?$new_password:''?>');
			window.location.href='index.php?r=user/user/update&id=<?=$model->id?>&edit=t';
	}
	$('.upload').click(function(){
		$('.inp').click();
	})
	
});
</script>
<div class="user-update">
	
	<!--
    <h1><?= Html::encode($this->title) ?></h1>
	-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<div class="modal fade ddddd">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
    	 <div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       		 <h4 class="modal-title"><?php echo Yii::t('app', 'Password has been Reset'); ?></h4>
      </div>
		<div class="modal-body">
			<form>  
			<br/>
            <div class="alert alert-success"><?php echo Yii::t('app', 'Password is'); ?> : <?=!empty($new_password)?$new_password:''?></div>
            <div class="form-actions">
                    <button type="button" class="close" data-dismiss="modal"><?php echo Yii::t('app', 'Close'); ?></button>
            </div>
	</form>
		</div>
   </div>
 </div>
</div>

