<!--
 *     The contents of this file are subject to the Initial
 *     Developer's Public License Version 1.0 (the "License");
 *     you may not use this file except in compliance with the
 *     License. You may obtain a copy of the License at
 *     http://www.liveobjects.org/livecrm/license.php
 *
 *     Software distributed under the License is distributed on
 *     an "AS IS" basis, WITHOUT WARRANTY OF ANY KIND, either
 *     express or implied.  See the License for the specific
 *     language governing rights and limitations under the License.
 *
 *
 *  The Original Code was created by Mohit Gupta (mohit.gupta@liveobjects.org) for LiveObjects Technologies Pvt. Ltd. (contact@liveobjects.org)
 *
 *  Copyright (c) 2014 - 2015 LiveObjects Technologies Pvt. Ltd.
 *  All Rights Reserved.
 *
 *  This translation and editing was done by Mohit Gupta of LiveObjects
 *
-->
<?php
use livefactory\modules\pmt\controllers\TaskController;
use livefactory\models\search\CommonModel;
use liveprojects\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
//use kartik\icons\Icon;
//Icon::map($this, Icon::EL); // Maps the Elusive icon font framework

/* @var $this \yii\web\View */
/* @var $content string */

error_reporting(0);
$protocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === FALSE ? 'http' : 'https';
//echo $protocol;
AppAsset::register ( $this );
$_SESSION['base_url']=$protocol."://$_SERVER[SERVER_NAME]$_SERVER[PHP_SELF]";
$base_url=substr_replace($_SESSION['base_url'],'web/index.php');
setcookie('include_folder',$base_url,time()+7200);
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

   <!-- <link href="css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Morris -->
    <link href="css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
<style>
.modal-backdrop.in{
	height:100%;
	position:fixed
}
.nav-tabs .active{
	border-bottom:1px solid #fff  !important;
}
.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus{
	border-color:#dddddd #dddddd #fff !important
}
.theme-config {display:none !important}
.theme-user {
    overflow: hidden;
    position: absolute;
    right: 0;
    top: 90px;
}

</style>
</head>

<?php 
CommonModel::destroyUserSessionStatus();
extract(CommonModel::getThemeSetting());
								if (!Yii::$app->user->isGuest)
								{

								?>

<body class="fixed-navigation <?=$COLLAPSE_MENU?'mini-navbar':''?> <?=$FIXED_SIDEBAR?'fixed-sidebar':''?> <?=$TOP_NAVBAR?'fixed-nav':''?> <?=$BOXED_LAYOUT?'boxed-layout':''?> <?=$BLUE_LIGHT?'skin-1':''?>  <?=$YELLOW?'skin-3':''?>">

<?php $this->beginBody();
if(Yii::$app->params['CHAT']){
?>
<div class="theme-user">
    <div class="theme-config-box">
        <div class="spin-icon">
            <i class="fa  fa-wechat"></i>
        </div>
        <div class="skin-setttings" style="max-height:400px; overflow:auto">
            <div class="title"><?php echo Yii::t('app', 'Users Login Status'); ?></div>
            <?php foreach(CommonModel::getAllUsers() as $userRow){?>
            <div class="setings-item">
                    <span>
                        <?= CommonModel::checkUserLoggedIn($userRow['id'])?'<a href="#">
<i class="fa fa-circle text-navy"></i></a>':'<a href="#">
<i class="fa fa-circle text-danger"></i></a>'?>
					 <?php	
					$replace1=array(' ','.');
					$replace2=array('','');
				?><a style="color:#666" href="javascript:void(0)" onclick="javascript:chatWith('<?=str_replace($replace1,$replace2,$userRow['first_name'])."_".trim(str_replace($replace1,$replace2,$userRow['last_name'])).'_'.$userRow['id']?>')"><?= $userRow['first_name']." ".$userRow['last_name']?></a>
                    </span>

                <div class="switch">
               
                    
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php } ?>

    <div id="wrapper">


	
          <?php
		


		  /*
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
												'class' => 'navbar-default navbar-static-side',
												'role' => 'navigation'
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
															] ,$myTask  
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
								*/
								function activeParentMenu($array){
									return  in_array($_GET['r'],$array)?'active':'';	
								}
								function activeMenu($link){
									return  $_GET['r']==$link?'active':'';	
								}
								?>
								


								 
								  <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidemenu <?=$FIXED_SIDEBAR?'slimScrollDiv':'sidebar-collapse'?>" <?=$FIXED_SIDEBAR?'style="position:relative;overflow:hidden;width:auto;height:100%"':''?>>
                <ul class="nav" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> <span>
                            <img alt="image" style="height:48px" src="../logo/logo.png" />
                            
                             </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?=Yii::$app->params['APPLICATION_NAME'] ?> <?php //echo Yii::$app->user->identity->first_name?> <?php // echo Yii::$app->user->identity->last_name?></strong>
                             </span> <span class="text-muted text-xs block"><?php //echo TaskController::getLoggedUserRole()?> </span>
                             </a>
                        </div>
                        <div class="logo-element">
                            <?php echo Yii::t('app', 'CRM'); ?>
                        </div>
                    </li>
                    <li class="<?=activeMenu('site/index')?>">
                        <a href="index.php?r=site/index"><i class="fa fa-th-large"></i> <span class="nav-label"><?php echo Yii::t('app', 'Dashboard'); ?></span></a>
                      
                    </li>
					<?php
						$customer_menu=array('customer/customer/create','customer/customer/index','customer/customer/customer-view');
					?>
                    <li class="<?= activeParentMenu($customer_menu)?>">
                        <a href="#"><i class="fa fa-users"></i> <span class="nav-label"><?php echo Yii::t('app', 'Clients'); ?></span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li class="<?=activeMenu('customer/customer/create')?>"><a href="index.php?r=customer/customer/create"><?php echo Yii::t('app', 'Add Client'); ?></a></li>
                            <li class="<?=activeMenu('customer/customer/index')?>"><a href="index.php?r=customer/customer/index"><?php echo Yii::t('app', 'Manage Clients'); ?></a></li>
                        </ul>
                    </li>
                    <?php
						$project_menu=array('pmt/project/create','pmt/project/index','pmt/project/project-view');
					?>
                    <li class="<?= activeParentMenu($project_menu)?>">
                        <a href="#"><i class="fa fa-briefcase"></i> <span class="nav-label"><?php echo Yii::t('app', 'Claims'); ?> </span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li class="<?=activeMenu('pmt/project/create')?>"><a href="index.php?r=pmt/project/create"><?php echo Yii::t('app', 'Add Claim'); ?></a></li>
                            <li class="<?=activeMenu('pmt/project/index')?>"><a href="index.php?r=pmt/project/index"><?php echo Yii::t('app', 'Manage Claims'); ?></a></li>
                        </ul>
                    </li>
                    <?php
						$task_menu=array('pmt/task/create','pmt/task/my-tasks','pmt/task/index','pmt/task/task-view','pmt/task/my-calendar','pmt/task/task-view');
					?>
                    <li class="<?= activeParentMenu($task_menu)?>">
                        <a href="#"><i class="fa fa-edit"></i> <span class="nav-label"><?php echo Yii::t('app', 'Incidents'); ?></span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li class="<?=activeMenu('pmt/task/create')?>"><a href="index.php?r=pmt/task/create"><?php echo Yii::t('app', 'Add Incident'); ?></a></li>
                            <li class="<?=activeMenu('pmt/task/my-tasks')?>"><a href="index.php?r=pmt/task/my-tasks"><?php echo Yii::t('app', 'My Incidents'); ?></a></li>
                            <li class="<?=activeMenu('pmt/task/index')?>"><a href="index.php?r=pmt/task/index"><?php echo Yii::t('app', 'Manage Incidents'); ?></a></li>
                            <li class="<?=activeMenu('pmt/task/my-calendar')?>"><a href="index.php?r=pmt/task/my-calendar"><?php echo Yii::t('app', 'My Calendar'); ?></a></li>
                        </ul>
                    </li>
					 <!--<?php
						$defect_menu=array('pmt/defect/create','pmt/defect/my-defects','pmt/defect/index','pmt/defect/defect-view','pmt/defect/my-calendar','pmt/defect/defect-view');
					?>
                    <li class="<?= activeParentMenu($defect_menu)?>">
                        <a href="#"><i class="fa fa-bug"></i> <span class="nav-label"><?php echo Yii::t('app', 'Complaints'); ?></span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li class="<?=activeMenu('pmt/defect/create')?>"><a href="index.php?r=pmt/defect/create"><?php echo Yii::t('app', 'Report Defect'); ?></a></li>
                            <li class="<?=activeMenu('pmt/defect/my-defects')?>"><a href="index.php?r=pmt/defect/my-defects"><?php echo Yii::t('app', 'My Defects'); ?></a></li>
                            <li class="<?=activeMenu('pmt/defect/index')?>"><a href="index.php?r=pmt/defect/index"><?php echo Yii::t('app', 'Manage Defects'); ?></a></li>
                            <li class="<?=activeMenu('pmt/defect/my-calendar')?>"><a href="index.php?r=pmt/defect/my-calendar"><?php echo Yii::t('app', 'My Calendar'); ?></a></li>
                        </ul>
                    </li>-->
                    <?php
						$report_menu=array('pmt/task/task-assignment-report','pmt/task/task-closed-reports','pmt/task/time-spent-report','pmt/task/task-all-reports','pmt/task/task-all-reports','pmt/defect/defect-assignment-report','pmt/defect/defect-closed-reports','pmt/defect/time-spent-report','pmt/defect/defect-all-reports','pmt/defect/defect-all-reports','customer/customer/customer-all-reports','customer/customer/new-customer-report','customer/customer/customer-type-report','customer/customer/customer-country-report','user/user/user-all-reports','user/user/user-type-report','user/user/user-status-report','user/user/new-user-report','pmt/task/task-all-reports');
						$pmt_menu=array('pmt/task/task-assignment-report','pmt/task/task-closed-reports','pmt/task/time-spent-report','pmt/task/task-all-reports','pmt/task/task-all-reports','pmt/defect/defect-assignment-report','pmt/defect/defect-closed-reports','pmt/defect/time-spent-report','pmt/defect/defect-all-reports','pmt/defect/defect-all-reports');
						$customer_menu=array('customer/customer/customer-all-reports','customer/customer/new-customer-report','customer/customer/customer-type-report','customer/customer/customer-country-report');
						$user_menu=array('user/user/user-all-reports','user/user/user-type-report','user/user/user-status-report','user/user/new-user-report');
					?>
                    <li class="<?= activeParentMenu($report_menu)?>">
                        <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label"><?php echo Yii::t('app', 'Reports'); ?></span><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li  class="<?= activeParentMenu($pmt_menu)?>">
                                <a href="#"><?php echo Yii::t('app', 'Claims Reports'); ?><span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
									 <li class="<?=activeMenu('pmt/task/task-assignment-report')?>">
                                        <a href="index.php?r=pmt/task/task-assignment-report"><?php echo Yii::t('app', 'Incident Assignment Report'); ?></a>
                                    </li>
									 <li class="<?=activeMenu('pmt/task/task-closed-reports')?>">
                                        <a href="index.php?r=pmt/task/task-closed-reports"><?php echo Yii::t('app', 'Incidents Closed Report'); ?></a>
                                    </li>
									 <li class="<?=activeMenu('pmt/task/time-spent-report')?>">
                                        <a href="index.php?r=pmt/task/time-spent-report"><?php echo Yii::t('app', 'Incidents Time Spent Report'); ?></a>
                                    </li>
                                     <!--<li class="<?=activeMenu('pmt/defect/defect-assignment-report')?>">
                                        <a href="index.php?r=pmt/defect/defect-assignment-report"><?php echo Yii::t('app', 'Defect Assignment Report'); ?></a>
                                    </li>
									 <li class="<?=activeMenu('pmt/defect/defect-closed-reports')?>">
                                        <a href="index.php?r=pmt/defect/defect-closed-reports"><?php echo Yii::t('app', 'Defect Closed Report'); ?></a>
                                    </li>
									 <li class="<?=activeMenu('pmt/defect/time-spent-report')?>">
                                        <a href="index.php?r=pmt/defect/time-spent-report"><?php echo Yii::t('app', 'Defect Time Spent Report'); ?></a>
                                    </li>-->
                                    <li class="<?=activeMenu('pmt/task/task-all-reports')?>">
                                        <a href="index.php?r=pmt/task/task-all-reports"><?php echo Yii::t('app', 'All Claims Reports'); ?></a>
                                    </li>
                                    <!--<li class="<?=activeMenu('pmt/defect/defect-all-reports')?>">
                                        <a href="index.php?r=pmt/defect/defect-all-reports"><?php echo Yii::t('app', 'All Defect Reports'); ?></a>
                                    </li>-->
                                </ul>
                                
                            </li>
                            <li  class="<?= activeParentMenu($customer_menu)?>">
                                <a href="#"><?php echo Yii::t('app', 'Customer Reports'); ?><span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                	<li class="<?=activeMenu('customer/customer/customer-type-report')?>"><a href="index.php?r=customer/customer/customer-type-report"><?php echo Yii::t('app', 'Client Type Report'); ?></a></li>
								<li class="<?=activeMenu('customer/customer/customer-country-report')?>"><a href="index.php?r=customer/customer/customer-country-report"><?php echo Yii::t('app', 'Client Country Report'); ?></a></li>
								<li class="<?=activeMenu('customer/customer/new-customer-report')?>"><a href="index.php?r=customer/customer/new-customer-report"><?php echo Yii::t('app', 'New Clients Report'); ?></a></li>
                                <li class="<?=activeMenu('customer/customer/customer-all-reports')?>"><a href="index.php?r=customer/customer/customer-all-reports"><?php echo Yii::t('app', 'All Clients Reports'); ?></a></li>
                                </ul>
         					</li>
                            <li  class="<?= activeParentMenu($user_menu)?>">
                                <a href="#"><?php echo Yii::t('app', 'User Reports'); ?><span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                	<li class="<?=activeMenu('user/user/user-type-report')?>"><a href="index.php?r=user/user/user-type-report"><?php echo Yii::t('app', 'User Type Report'); ?></a></li>
								<li class="<?=activeMenu('user/user/user-status-report')?>"><a href="index.php?r=user/user/user-status-report"><?php echo Yii::t('app', 'User Status Report'); ?></a></li>
								<li class="<?=activeMenu('user/user/new-user-report')?>"><a href="index.php?r=user/user/new-user-report"><?php echo Yii::t('app', 'New Users Report'); ?></a></li>
                                <li class="<?=activeMenu('user/user/user-all-reports')?>"><a href="index.php?r=user/user/user-all-reports"><?php echo Yii::t('app', 'All User Reports'); ?></a></li>
                                </ul>
         					</li>
                        </ul>
                    </li>
                 
                  <!--
                    <li class="special_link">
                        <a href="package.html"><i class="fa fa-database"></i> <span class="nav-label">Package</span></a>
                    </li>
					-->
                </ul>

            </div>
        </nav>

	
		
        <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar   <?=$TOP_NAVBAR?($BOXED_LAYOUT?'navbar-static-top':'navbar-fixed-top'):'navbar-static-top'?> gray-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" name="search_results" method="post" action="index.php?r=site/search-results">
             <?php Yii::$app->request->enableCsrfValidation = true; ?>
              <input type="hidden" name="_csrf" value="<?php echo $this->renderDynamic('return Yii::$app->request->csrfToken;'); ?>">
                <div class="form-group">
                    <input type="text" value="<?=$_REQUEST['top_search']?>"  placeholder="<?php echo Yii::t('app', 'Search for something'); ?>..." class="form-control" name="top_search" id="top-search" onBlur="document.search_results.submit()">
                </div>
            </form>
        </div>
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-muted welcome-message time_widget"></span>
                    <span class="m-r-sm text-muted welcome-message lead_time_widget"></span>
                    <span class="m-r-sm text-muted welcome-message defect_time_widget"></span>
                </li>
				<!--
                <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope"></i>  <span class="label label-warning">16</span>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="img/a7.jpg">
                                </a>
                                <div>
                                    <small class="pull-right">46h ago</small>
                                    <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="img/a4.jpg">
                                </a>
                                <div>
                                    <small class="pull-right text-navy">5h ago</small>
                                    <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="img/profile.jpg">
                                </a>
                                <div>
                                    <small class="pull-right">23h ago</small>
                                    <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                    <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
			
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="mailbox.html">
                                    <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                                </a>
                            </div>
                        </li>
						
                    </ul>
                </li>
				-->
                <li class="dropdown">
                	<?php
					$alertCount = count(CommonModel::getPendingTaksCount());
					if(Yii::$app->user->identity->user_role_id =='1'){
						$alertCount = $alertCount+CommonModel::getInactiveUsers();
					}
					?>
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i>  <span class="label label-primary"><?=$alertCount?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="index.php?r=pmt/task/need-actions">
                                <div>
                                    <i class="fa fa-edit"></i> <?php echo Yii::t('app', 'Pending Incidents'); ?>
                                    <span class="pull-right text-muted small"><span class="badge"><?=count(CommonModel::getPendingTaksCount());?></span></span>
                                </div>
                            </a>
                        </li>
                        <?php
						if(Yii::$app->user->identity->user_role_id =='1'){?>
						
                        <li class="divider"></li>
                        <li>
                            <a href="index.php?User[status]=0&r=user%2Fuser%2Findex">
                                <div>
                                    <i class="fa fa-users"></i> <?php echo Yii::t('app', 'Users Waiting Approval'); ?> 
                                    <span class="pull-right text-muted small"><span class="badge"><?=CommonModel::getInactiveUsers()?></span></span>
                                </div>
                            </a>
                        </li>
                        <?php 
						}
						?>
                        <!--<li class="divider"></li>
                        <li>
                            <a href="grid_options.html">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="notifications.html">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>-->
                    </ul>
                </li>
				
				<li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-bar-chart-o"></i>  
                    </a>
                    <ul class="dropdown-menu" style="height:500px; overflow:auto">
								<li class="<?=activeMenu('pmt/task/task-assignment-report')?>"><a href="index.php?r=pmt/task/task-assignment-report"><?php echo Yii::t('app', 'Incident Assignment Report'); ?></a></li>
								<li class="<?=activeMenu('pmt/task/task-closed-reports')?>"><a href="index.php?r=pmt/task/task-closed-reports"><?php echo Yii::t('app', 'Incidents Closed Report'); ?></a></li>
								<li class="<?=activeMenu('pmt/task/time-spent-report')?>"><a href="index.php?r=pmt/task/time-spent-report"><?php echo Yii::t('app', 'Incident Time Spent Report'); ?></a></li>
								<li class="<?=activeMenu('pmt/task/task-all-reports')?>"><a href="index.php?r=pmt/task/task-all-reports"><?php echo Yii::t('app', 'All Claims Reports'); ?></a></li>

	                            <!--<li class="divider"></li>
								<li class="<?=activeMenu('pmt/defect/defect-assignment-report')?>">
                                        <a href="index.php?r=pmt/defect/defect-assignment-report"><?php echo Yii::t('app', 'Defect Assignment Report'); ?></a>
                                    </li>
									 <li class="<?=activeMenu('pmt/defect/defect-closed-reports')?>">
                                        <a href="index.php?r=pmt/defect/defect-closed-reports"><?php echo Yii::t('app', 'Defect Closed Report'); ?></a>
                                    </li>
									 <li class="<?=activeMenu('pmt/defect/time-spent-report')?>">
                                        <a href="index.php?r=pmt/defect/time-spent-report"><?php echo Yii::t('app', 'Defect Time Spent Report'); ?></a>
                                    </li>
                                    <li class="<?=activeMenu('pmt/defect/defect-all-reports')?>">
                                        <a href="index.php?r=pmt/defect/defect-all-reports"><?php echo Yii::t('app', 'All Defect Reports'); ?></a>
                                    </li>-->
<li class="divider"></li>
                                <li class="<?=activeMenu('customer/customer/customer-type-report')?>"><a href="index.php?r=customer/customer/customer-type-report"><?php echo Yii::t('app', 'Client Type Report'); ?></a></li>
								<li class="<?=activeMenu('customer/customer/customer-country-report')?>"><a href="index.php?r=customer/customer/customer-country-report"><?php echo Yii::t('app', 'Client Country Report'); ?></a></li>
								<li class="<?=activeMenu('customer/customer/new-customer-report')?>"><a href="index.php?r=customer/customer/new-customer-report"><?php echo Yii::t('app', 'New Cients Report'); ?></a></li>
                                <li class="<?=activeMenu('customer/customer/customer-all-reports')?>"><a href="index.php?r=customer/customer/customer-all-reports"><?php echo Yii::t('app', 'All Clients Reports'); ?></a></li>
                                <li class="divider"></li>
                                	<li class="<?=activeMenu('user/user/user-type-report')?>"><a href="index.php?r=user/user/user-type-report"><?php echo Yii::t('app', 'User Type Report'); ?></a></li>
								<li class="<?=activeMenu('user/user/user-status-report')?>"><a href="index.php?r=user/user/user-status-report"><?php echo Yii::t('app', 'User Status Report'); ?></a></li>
								<li class="<?=activeMenu('user/user/new-user-report')?>"><a href="index.php?r=user/user/new-user-report"><?php echo Yii::t('app', 'New Users Report'); ?></a></li>
                                <li class="<?=activeMenu('user/user/user-all-reports')?>"><a href="index.php?r=user/user/user-all-reports"><?php echo Yii::t('app', 'All User Reports'); ?></a></li>
                    </ul>
                </li>
				
					
				<?php if(Yii::$app->user->identity->user_role_id =='1'){?>
				 <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-cog"></i>  
                    </a>
                    <ul class="dropdown-menu" style="height:500px; overflow:auto">
								<li class="<?=activeMenu('customer/customer-type/index')?>"><a href="index.php?r=customer/customer-type/index"><?php echo Yii::t('app', 'Client Types'); ?></a></li>
								<li class="divider"></li>
								<li class="<?=activeMenu('pmt/project-type/index')?>"><a href="index.php?r=pmt/project-type/index"><?php echo Yii::t('app', 'Claim Position'); ?></a></li>
								<li class="<?=activeMenu('pmt/project-status/index')?>"><a href="index.php?r=pmt/project-status/index"><?php echo Yii::t('app', 'Adjuster Status'); ?></a></li>
								<li class="<?=activeMenu('pmt/task-priority/index')?>"><a href="index.php?r=pmt/task-priority/index"><?php echo Yii::t('app', 'Incident Priority'); ?></a></li>
								<li class="<?=activeMenu('pmt/task-status/index')?>"><a href="index.php?r=pmt/task-status/index"><?php echo Yii::t('app', 'Incident  Status'); ?></a></li>
								<!--<li class="<?=activeMenu('pmt/defect-priority/index')?>"><a href="index.php?r=pmt/defect-priority/index"><?php echo Yii::t('app', 'Defect Priority'); ?></a></li>
								<li class="<?=activeMenu('pmt/defect-status/index')?>"><a href="index.php?r=pmt/defect-status/index"><?php echo Yii::t('app', 'Defect Status'); ?></a></li>-->
								<li class="divider"></li>
								<li class="<?=activeMenu('user/user/index')?>"><a href="index.php?r=user/user/index"><?php echo Yii::t('app', 'Users'); ?></a></li>
								<li class="<?=activeMenu('user/user-type/index')?>"><a href="index.php?r=user/user-type/index"><?php echo Yii::t('app', 'User Types'); ?></a></li>
								<li class="<?=activeMenu('user/user-role/index')?>"><a href="index.php?r=user/user-role/index"><?php echo Yii::t('app', 'User Roles'); ?></a></li>
                                <li class="<?=activeMenu('user/user/user-sessions')?>"><a href="index.php?r=user/user/user-sessions"><?php echo Yii::t('app', 'User Session History'); ?></a></li>
								<li class="divider"></li>
								<li class="<?=activeMenu('liveobjects/address/index')?>"><a href="index.php?r=liveobjects/address/index"><?php echo Yii::t('app', 'Addresses'); ?></a></li>
								<li class="<?=activeMenu('liveobjects/country/index')?>"><a href="index.php?r=liveobjects/country/index"><?php echo Yii::t('app', 'Countries'); ?></a></li>
								<li class="<?=activeMenu('liveobjects/state/index')?>"><a href="index.php?r=liveobjects/state/index"><?php echo Yii::t('app', 'States'); ?></a></li>
								<li class="<?=activeMenu('liveobjects/city/index')?>"><a href="index.php?r=liveobjects/city/index"><?php echo Yii::t('app', 'Cities'); ?></a></li>
								<li class="divider"></li>
								<li class="<?=activeMenu('liveobjects/email-template')?>"><a href="index.php?r=liveobjects/email-template"><?php echo Yii::t('app', 'Email Template'); ?></a></li>
                                <li class="<?=activeMenu('liveobjects/glocalization')?>"><a href="index.php?r=liveobjects/glocalization"><?php echo Yii::t('app', 'Glocalization'); ?></a></li>
                                <li class="<?=activeMenu('liveobjects/currency')?>"><a href="index.php?r=liveobjects/currency"><?php echo Yii::t('app', 'Nature of Claim'); ?></a></li>
                                <li class="<?=activeMenu('liveobjects/setting/send-verified-code')?>"><a href="index.php?r=liveobjects/setting/send-verified-code"><?php echo Yii::t('app', 'Truncate Table'); ?></a></li>
                                <li class="<?=activeMenu('liveobjects/setting/import-data')?>"><a href="index.php?r=liveobjects/setting/import-data"><?php echo Yii::t('app', 'Import Data'); ?></a></li>
                                <li class="divider"></li>
								<li class="<?=activeMenu('liveobjects/setting')?>"><a href="index.php?r=liveobjects/setting"><?php echo Yii::t('app', 'Settings'); ?></a></li>
                    </ul>
                </li>
				<?php } ?>
				 <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                    	<?php if(file_exists('../users/'.Yii::$app->user->identity->id.'.png')){?>
							<img alt="image" style="height:20px" src="../users/<?=Yii::$app->user->identity->id; ?>.png" />
                             <?php echo Yii::$app->user->identity->first_name." ".Yii::$app->user->identity->last_name; ?>
						 <?php }else{?>
                         <img alt="image" style="height:20px" src="../users/nophoto.jpg" /> <?php echo Yii::$app->user->identity->first_name." ".Yii::$app->user->identity->last_name; ?>
                         <?php } ?>
                    </a>
                    <ul class="dropdown-menu">


								<li class="<?=activeMenu('user/user/view')?>"><a href="index.php?r=user/user/view&id=<?php echo Yii::$app->user->getId();  ?>"><i class="fa fa-user"></i>
 Profile</a></li>
<!--								<li class="<?=activeMenu('pmt/project-type/index')?>"><a href="index.php?r=pmt/project-type/index"><i class="fa fa-envelope"></i> Mailbox</a></li> -->
								<li class="<?=activeMenu('user/user/change-password')?>"><a href="index.php?r=user/user/change-password"><i class="fa fa-exchange"></i>
 Change Password</a></li>
								<li class="<?=activeMenu('site/logout')?>"><a href="<?= Url::to(['/site/logout'])?>" data-method="post"><i class="fa fa-sign-out"></i> Log out</a></li>
                    </ul>
                </li>
				
				<!--
				 <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-cog"></i>  
                    </a>
                    <ul class="dropdown-menu">
								<li class="<?=activeMenu('customer/customer-type/index')?>"><a href="index.php?r=customer/customer-type/index">My Profile</a></li>
								<li class="<?=activeMenu('pmt/project-type/index')?>"><a href="index.php?r=pmt/project-type/index">My Privileges</a></li>
								<li class="<?=activeMenu('pmt/project-status/index')?>"><a href="index.php?r=pmt/project-status/index">Change Password</a></li>
								<li class="<?=activeMenu('liveobjects/logo')?>"><a href="index.php?r=liveobjects/logo"><i class="fa fa-sign-out"></i> Log out</li>
                    </ul>
                </li>
				-->

				<!--
                <li>
                    <a href="login.html">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
				-->
				</ul>

        </nav>
        </div>
			
			  <!-- lets make this configuration user preferenace if wants to show the title & breadcrump -->

		 
			<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2><?= Html::encode($this->title) ?></h2>
                    <ol class="breadcrumb">
                       <?php  echo Breadcrumbs::widget ( [ 'links' => isset ( $this->params ['breadcrumbs'] ) ? $this->params ['breadcrumbs'] : [ ] ] ) ?>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
			

		  <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                     <div class="col-lg-12">
						
						
						<?= $content?>
		
                    </div>
                </div>
            </div>

        <div class="footer">
            <div class="pull-right">
                M&M <strong>DerryAce</strong> <a href="https://twitter.com/SquinTheAce">#TheMadScientist</a>
            </div>
            <div>
                <strong>Copyright &copy; </strong> <?=Yii::$app->params['company']['company_name'] ?> | All Rights Reserved.
            </div>
        </div>

        </div>
    </div>

	<?php $this->endBody()?>


      <?php
								}
	  else
	  {
		  ?>
		  <?= $content?>
		  <?php
	  }

		?>

		 

          


    <!-- Mainly scripts -->
    <!--<script src="js/jquery-2.1.1.js"></script>-->
    <?php
		if(strpos($_GET['r'],'my-calendar') !== false){?>
        <script src='../include/calendar/fullcalendar.min.js'></script>
			
	<?php	}
	 if($_GET['r']=='site/index'){?>
   <!--	 <script src="js/bootstrap.min.js"></script>-->
    <?php }else{
		if(strpos($_GET['r'], 'index')===false){?>
			<!-- <script src="js/bootstrap.min.js"></script>-->
	<?php	}
	?>
    
    <?php 
	}if($_GET['r']=='liveobjects/config-item'){?>
   	 <!--<script src="js/bootstrap.min.js"></script>-->
    <?php }?>
    <div class="fileinclude"></div>
    <script>
		$(document).ready(function(e) {
		   if(!$('body').find("[src$='bootstrap.js']").length){
			  var script=document.createElement('script');
				script.type='text/javascript';
				script.src='js/bootstrap.min.js';
				
				$("body").append(script);
		   }
		});
	</script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Flot -->
    <script src="js/plugins/flot/jquery.flot.js"></script>
    <script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="js/plugins/flot/jquery.flot.symbol.js"></script>
    <script src="js/plugins/flot/curvedLines.js"></script>

    <!-- Peity -->
    <script src="js/plugins/peity/jquery.peity.min.js"></script>
    <script src="js/demo/peity-demo.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>

    <!-- jQuery UI -->
   <!-- <script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>-->

    <!-- Jvectormap -->
    <script src="js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

    <!-- Sparkline -->
    <!--<script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>-->

    <!-- Sparkline demo data  -->
   <!-- <script src="js/demo/sparkline-demo.js"></script>-->

    <!-- ChartJS-->
    <!--<script src="js/plugins/chartJs/Chart.min.js"></script>-->
	<script src="../include/jPages.js"></script>
    <?php if(Yii::$app->params['CHAT']){?>
<script src="../include/js/chat.js"></script>
<link type="text/css" rel="stylesheet" media="all" href="../include/css/chat.css" />

<?php } ?>
<style>
.chatboxcontent{
	width:225px
}
</style>
    
  <script>
  $(document).ready(function(e) {
	 // setTimeout(function(){
    	$('.theme-config').hide();
	//  },1000);
	$('a[data-toggle="tab"]').on('shown.bs.tab', function () {

        //save the latest tab; use cookies if you like 'em better:

        localStorage.setItem('lastTab_leadview', $(this).attr('href'));

    });



    //go to the latest tab, if it exists:

    var lastTab_leadview = localStorage.getItem('lastTab_leadview');

    if ($('a[href=' + lastTab_leadview + ']').length > 0) {

        $('a[href=' + lastTab_leadview + ']').tab('show');

    }

    else

    {

        // Set the first tab if cookie do not exist

        $('a[data-toggle="tab"]:first').tab('show');

    }

});
	if('<?=$_COOKIE['taskStartedId']?>' != ''){
		setInterval(function(){
		jQuery.post('ajax_clock.php',function(result){
			var alink ='<a href="index.php?r=pmt/task/task-view&id=<?=$_COOKIE['taskStartedId']?>"><i class="glyphicon glyphicon-time"></i> '+result+'</a>';
				jQuery(".time_widget").html(alink);	
			})
		},1000)
	}
	if('<?=$_COOKIE['leadStartedId']?>' != ''){
		setInterval(function(){
		jQuery.post('ajax_clock1.php',function(result){
			var alink ='<a href="index.php?r=sales/lead/lead-view&id=<?=$_COOKIE['leadStartedId']?>"><i class="glyphicon glyphicon-time"></i> '+result+'</a>';
				jQuery(".lead_time_widget").html(alink);	
			})
		},1000)
	}
	if('<?=$_COOKIE['defectStartedId']?>' != ''){
		setInterval(function(){
		jQuery.post('ajax_clock2.php',function(result){
			var alink ='<a href="index.php?r=pmt/defect/defect-view&id=<?=$_COOKIE['defectStartedId']?>"><i class="glyphicon glyphicon-time"></i> '+result+'</a>';
				jQuery(".defect_time_widget").html(alink);	
			})
		},1000)
	}
	</script>
    <script type="text/javascript">
	
	
		if('<?=$_COOKIE['taskStartedId']?>' != ''){
			var idleTime = 0;
			$(document).ready(function () {
				//Increment the idle time counter every minute.
				var idleInterval = setInterval(timerIncrement, 60000); // 1 minute
			
				//Zero the idle timer on mouse movement.
				$(this).mousemove(function (e) {
					idleTime = 0;
				});
				$(this).keypress(function (e) {
					idleTime = 0;
				});
				$('.spin-icon').click(function(){
					$('.theme-user .theme-config-box').toggleClass('show');
				})
			});
			
			function timerIncrement() {
				idleTime = idleTime + 1;
				if (idleTime > 9) { // 10 minutes
					var r = confirm("Your session will expire in 2 mins. Do you want to continue the session?");
					if (r == true) {
						idleTime =0;
					} else {
						window.location.href='index.php?r=pmt%2Ftask%2Ftask-view&id=<?=$_COOKIE['taskStartedId']?>&tasknotes=Session Expired';
					}
					
				}
			}
		}
		if('<?=$_COOKIE['defectStartedId']?>' != ''){
			var idleTime = 0;
			$(document).ready(function () {
				//Increment the idle time counter every minute.
				var idleInterval = setInterval(timerIncrement, 60000); // 1 minute
			
				//Zero the idle timer on mouse movement.
				$(this).mousemove(function (e) {
					idleTime = 0;
				});
				$(this).keypress(function (e) {
					idleTime = 0;
				});
				$('.spin-icon').click(function(){
					$('.theme-user .theme-config-box').toggleClass('show');
				})
			});
			
			function timerIncrement() {
				idleTime = idleTime + 1;
				if (idleTime > 9) { // 10 minutes
					var r = confirm("Your session will expire in 2 mins. Do you want to continue the session?");
					if (r == true) {
						idleTime =0;
					} else {
						window.location.href='index.php?r=pmt/defect/defect-view&id=<?=$_COOKIE['defectStartedId']?>&defectnotes=Session Expired';
					}
					
				}
			}
		}
		if('<?=$_COOKIE['leadStartedId']?>' != ''){
			var idleTime = 0;
			$(document).ready(function () {
				//Increment the idle time counter every minute.
				var idleInterval = setInterval(timerIncrement, 60000); // 1 minute
			
				//Zero the idle timer on mouse movement.
				$(this).mousemove(function (e) {
					idleTime = 0;
				});
				$(this).keypress(function (e) {
					idleTime = 0;
				});
				$('.spin-icon').click(function(){
					$('.theme-user .theme-config-box').toggleClass('show');
				})
			});
			
			function timerIncrement() {
				idleTime = idleTime + 1;
				if (idleTime > 9) { // 10 minutes
					var r = confirm("Your session will expire in 2 mins. Do you want to continue the session?");
					if (r == true) {
						idleTime =0;
					} else {
						window.location.href='index.php?r=sales/lead/lead-view&id=<?=$_COOKIE['leadStartedId']?>&leadnotes=Session Expired';
					}
					
				}
			}
		}
		</script> 
       


	<!--
</body>
</html>
-->
    
</body>
</html>

<!--
<footer class="footer">
		<div class="container">
			<p class="pull-left">&copy; LiveObjects Technologies Pvt. Ltd. <?= date('Y') ?></p>
			<p class="pull-right"><?= Yii::powered("LiveFactory") ?></p> 
		</div>
	</footer>
	-->


<?php $this->endPage()?>
