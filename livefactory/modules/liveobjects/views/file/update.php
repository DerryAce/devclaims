<?php
use yii\helpers\Html;

/**
 *
 * @var yii\web\View $this
 * @var common\models\File $model
 */

$this->title = 'Update : ' . ' ' . $model->file_title;
$this->params ['breadcrumbs'] [] = [ 
		'label' => 'Files',
		'url' => [ 
				'index' 
		] 
];
$this->params ['breadcrumbs'] [] = [ 
		'label' => $model->file_title,
		'url' => [ 
				'view',
				'id' => $model->id 
		] 
];
$this->params ['breadcrumbs'] [] = 'Update';
?>
<div class="file-update">
	<div class="page-header">
		<h1><?= Html::encode($this->title) ?></h1>
	</div>
	
	<?php
	if (strpos ( $model->file_type, 'image' ) !== false) {
		
		echo $this->render ( '_form_image', [ 
				'model' => $model 
		] );
	}
	elseif (strpos ( $model->file_type, 'video' ) !== false) {
	
		echo $this->render ( '_form_video', [
				'model' => $model
				] );
	}
	elseif (strpos ( $model->file_type, 'audio' ) !== false) {
	
		echo $this->render ( '_form_audio', [
				'model' => $model
				] );
	}
	else {
	
		echo $this->render ( '_form_file', [
				'model' => $model
				] );
	}
	
	?>

</div>
