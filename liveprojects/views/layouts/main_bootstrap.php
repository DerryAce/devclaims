<?php
use livefactory\modules\pmt\controllers\TaskController;
use liveprojects\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
//use kartik\icons\Icon;
//Icon::map($this, Icon::EL); // Maps the Elusive icon font framework

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register ( $this );
$_SESSION['base_url']="http://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]";
setcookie('include_folder','/liveprojects/include/',time()+7200);
setcookie('pagepath',$_GET['r'],time()+7200);
?>
<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags()?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head()?>
<style>
.navbar-brand{
	text-indent:90px
}
</style>
</head>
<body>    
<?php
	 $this->beginBody()?>
    <div class="wrap">
        <?php
								NavBar::begin ( [ 
										'brandLabel' => '<img src="../logo/logo.png" height="30" style="display:block;margin-right:7px; background: none repeat scroll 0 0 rgb(204, 204, 204);
										    height: 51px;
										    margin-right: 9px;
										    padding: 8px;
										    position: absolute;
										    text-indent: 68px;
										    top: 0;">LiveObjects',
										'brandUrl' => Yii::$app->homeUrl,
										'options' => [ 
												'class' => 'navbar-inverse navbar-fixed-top' 
										],
										
								] );
								if(Yii::$app->user->identity->username !='admin'){
								$myTask=['label' => 'My Tasks','url' => ['/pmt/task/my-tasks']];
								}else{
								$myTask=['label' => ''];
								}
								if (! Yii::$app->user->isGuest)
								{
									$menuItems = [ 
											[ 
													'label' => 'Dashboard',
													'url' => [ 
															'/site/index' 
													] 
											],
											
											// ['label' => 'Manage Contacts', 'url' => ['/contact/index']],
											
											[ 
													'label' => 'Customers',
													'encodeLabels' => true,
													'items' => [ 
															
															[ 
																	'label' => 'Add Customer',
																	'url' => [ 
																			'/customer/customer/create' 
																	] 
															],
															[ 
																	'label' => 'Manage Customers',
																	'url' => [ 
																			'/customer/customer/index' 
																	] 
															] 
													] 
											],
											
											[ 
													'label' => 'Projects',
													'items' => [ 
															
															[ 
																	'label' => 'Add Project',
																	'url' => [ 
																			'/pmt/project/create' 
																	] 
															],
															[ 
																	'label' => 'Manage Projects',
																	'url' => [ 
																			'/pmt/project/index' 
																	] 
															] 
													] 
											],
											
											[ 
													'label' => 'Tasks',
													'items' => [ 
															
															[ 
																	'label' => 'Add Task',
																	'url' => [ 
																			'/pmt/task/create' 
																	] 
															],
															[ 
																	'label' => 'Manage Tasks ',
																	'url' => [ 
																			'/pmt/task/index' 
																	] 
															] ,$myTask  /*,
															[ 
																	'label' => 'Need Actions ('.TaskController::getTotalNeedAction().')',
																	'url' => [ 
																			'/pmt/task/need-actions' 
																	] 
															]*/ 
													] 
											] 
									];
									
									$menuItems2 = [ 
											[ 
													'label' => '',
													'url' => [ 
															'#' 
													] ,
													'options' => [ 
															'class' => 'time_widget' 
													] 
											] ,
											[ 
													'label' => '<span class="glyphicon glyphicon-bell"></span>',
													'items' => [ 
															
															[ 
																	'label' => 'Open Tasks <span class="badge">'.TaskController::getTotalNeedAction().'</span>',
																	'url' => [ 
																			'/pmt/task/my-tasks' 
																	] 
															]
												]
											] ,
											[ 
													'label' => '<span class=" glyphicon glyphicon-signal"></span>',
													'items' => [ 
															
															[ 
																	'label' => 'Task Reports',
																	'url' => [ 
																			'/pmt/task/task-all-reports' 
																	] 
															],
															[ 
																	'label' => 'Task Assignments',
																	'url' => [ 
																			'/pmt/task/task-assignment-report' 
																	] 
															],
															[ 
																	'label' => 'Task Closed Reports',
																	'url' => [ 
																			'/pmt/task/task-closed-reports' 
																	] 
															],
															[ 
																	'label' => 'Task Spent Time Report',
																	'url' => [ 
																			'/pmt/task/time-spent-report' 
																	] 
															]
												]
											] ,
											[ 
													'label' => '<span class="glyphicon glyphicon-cog"></span>',
													'items' => [ 
															
															[ 
																	'label' => 'Customer Types',
																	'url' => [ 
																			'/customer/customer-type/index' 
																	] 
															],
															
															[ 
																	'label' => 'Project Types',
																	'url' => [ 
																			'/pmt/project-type/index' 
																	] 
															],
															[ 
																	'label' => 'Project Status',
																	'url' => [ 
																			'/pmt/project-status/index' 
																	] 
															],
															
															[ 
																	'label' => 'Task Priority',
																	'url' => [ 
																			'/pmt/task-priority/index' 
																	] 
															],
															[ 
																	'label' => 'Task Status',
																	'url' => [ 
																			'/pmt/task-status/index' 
																	] 
															],
															
															[ 
																	'label' => 'Users',
																	'url' => [ 
																			'/user/user/index' 
																	] 
															],
															[ 
																	'label' => 'User Types',
																	'url' => [ 
																			'/user/user-type/index' 
																	] 
															],
															[ 
																	'label' => 'User Roles',
																	'url' => [ 
																			'/user/user-role/index' 
																	] 
															],
															[ 
																	'label' => 'Addresses',
																	'url' => [ 
																			'/liveobjects/address/index' 
																	] 
															],
															[ 
																	'label' => 'Countries',
																	'url' => [ 
																			'/liveobjects/country/index' 
																	] 
															],
															[ 
																	'label' => 'States',
																	'url' => [ 
																			'/liveobjects/state/index' 
																	] 
															],
															[ 
																	'label' => 'Cities',
																	'url' => [ 
																			'/liveobjects/city/index' 
																	] 
															],
															[ 
																	'label' => 'Logo',
																	'url' => [ 
																			'/pmt/logo' 
																	] 
															] 
													] 
											] 
									];
								}
								
								if (Yii::$app->user->isGuest)
								{
									$menuItems2 [] = [ 
											'label' => 'Login',
											'url' => [ 
													'/site/login' 
											] 
									];
								}
								else
								{
									$menuItems2 [] = [ 
											'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
											'url' => [ 
													'/site/logout' 
											],
											'linkOptions' => [ 
													'data-method' => 'post' 
											] 
									];
								}
								if (sizeof ( $menuItems ) > 0)
								{
									echo Nav::widget ( [ 
											'options' => [ 
													'class' => 'navbar-nav navbar-left' 
											],'encodeLabels' => false, 
											'items' => $menuItems 
									] );
								}
								if (sizeof ( $menuItems2 ) > 0)
								{
									echo Nav::widget ( [ 
											'options' => [ 
													'class' => 'navbar-nav navbar-right' 
											],'encodeLabels' => false, 
											'items' => $menuItems2 
									] );
								}
								NavBar::end ();
								?>

        <div class="container">
        <!-- <?=Breadcrumbs::widget ( [ 'links' => isset ( $this->params ['breadcrumbs'] ) ? $this->params ['breadcrumbs'] : [ ] ] )?>-->
        <?= $content?>
        </div>
	</div>

	<footer class="footer">
		<div class="container">
			<p class="pull-left">&copy; LiveObjects Technologies Pvt. Ltd. <?=$_COOKIE['pagepath']. date('Y') ?></p>
			<!--<p class="pull-right"><?= Yii::powered("LiveFactory") ?></p> -->
		</div>
	</footer>
    
    <?php $this->endBody();?>
<script src="../include/jPages.js"></script>

    <script>
	if('<?=$_COOKIE['taskStartedId']?>' != ''){
		setInterval(function(){
		jQuery.post('ajax_clock.php',function(result){
			var alink ='<a href="index.php?r=pmt/task/task-view&id=<?=$_COOKIE['taskStartedId']?>"><i class="glyphicon glyphicon-time"></i> '+result+'</a>';
				jQuery(".time_widget").html(alink);	
			})
		},1000)
	}
	</script>
</body>
</html>
<?php $this->endPage()?>
