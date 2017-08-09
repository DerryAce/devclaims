<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\Status $searchModel
 */

$this->title = Yii::t('app', 'Theme Settings');
$this->params['breadcrumbs'][] = $this->title;
?>
<script>
function reloadPage(){
	document.location.href='index.php?r=liveobjects/theme'	
}
	if('<?=$reload?>'=='yes'){
		reloadPage()
	}
</script>
<div class="col-lg-6 col-sm-offset-3">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Theme Settings</h5>
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
        	<?php if($msg){?>
            	<div class="alert alert-success"><?=$msg?></div>
            <?php } ?>
            <form  action="" method="post" enctype="multipart/form-data" name="task_time" id="task_time">
              <?php Yii::$app->request->enableCsrfValidation = true; ?>
    <input type="hidden" name="_csrf" value="<?php echo $this->renderDynamic('return Yii::$app->request->csrfToken;'); ?>">
    			<?php foreach($dataProvider as $row){
					if($row['config_item_value'] !='Default'){
					?>
                	<div class="row">
                			<input type="hidden" value="<?=$row['id']?>" name="ids[]">
                            
                       
                    	<div class="form-group">
                        	<div class="col-sm-4">
                            <label><?=$row['config_item_value']?></label>
                            </div>
                            <div class="col-sm-8">
                            : Yes:
                            <input type="radio" name="active<?=$row['id']?>" value="1" <?=$row['active']=='1'?'checked':''?>>
                            No:
                            <input type="radio" name="active<?=$row['id']?>" value="0" <?=$row['active']=='1'?'':'checked'?>>
                        </div>
                   		 </div>
                          
                    </div>
                    <hr/>
                    <?php }
					}
					
					 ?>
                     <div class="row">
                     
                     <div class="form-group">
                     	<div class="col-sm-4">
                        	<label>Theme Color</label>
                        </div>
                        <div class="col-sm-4">
                        	<select name="color" class="form-control">
                            	<option value="">--Select--</option>
                            	<?php foreach($dataProviderColor as $row1){?>
                                	<option value="<?=$row1['id']?>" <?=$row1['active']?'selected':''?>><?=$row1['config_item_value']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        </div>
                     </div>
                <br/><br/>
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
		

            </form>
        </div>
    </div>
</div>
