<?php



use yii\helpers\Html;

use kartik\grid\GridView;

use yii\widgets\Pjax;

use yii\helpers\ArrayHelper;



/**

 *

 * @var yii\web\View $this

 * @var yii\data\ActiveDataProvider $dataProvider

 * @var livefactory\models\search\Address $searchModel

 */



$this->title = Yii::t ( 'app', 'Logo' );

$this->params ['breadcrumbs'] [] = $this->title;

?>
<div class="logo-index">
	<!--
	<div class="page-header">
		<h1><?= Html::encode($this->title) ?></h1>
	</div>
	-->
    <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Logo <small class="m-l-sm">Add / Update Logo</small></h5>
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
						<form method="post" enctype="multipart/form-data">
    <?php Yii::$app->request->enableCsrfValidation = true; ?>
    <input type="hidden" name="_csrf" value="<?php echo $this->renderDynamic('return Yii::$app->request->csrfToken;'); ?>">
    <div class="row">
    	<div class="col-sm-7">
        	<input type="file" class="form-control" name="logo">
        </div>
        <div class="col-sm-2">
        	<input type="submit" value="Upload" class="btn btn-primary btn-block">
        </div>
        <div class="col-sm-3">
        	<img src="../logo/logo.png" class="img-responsive">
        </div>
    </div>
	</form>
                    </div>
                </div>
    

</div>
