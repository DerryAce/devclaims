<?php

use livefactory\modules\pmt\controllers\TaskController;

use livepmt\assets\AppAsset;

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

setcookie('include_folder','/livepmt/include/',time()+7200);

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



</head>

<body class="fixed-navigation">



<?php $this->beginBody()?>

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

            <div class="sidebar-collapse">

                <ul class="nav" id="side-menu">

                    <li class="nav-header">

                        <div class="dropdown profile-element"> <span>

                            <img alt="image" style="height:40px" src="../logo/logo.png" />

                            

                             </span>

                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">

                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?=Yii::$app->user->identity->first_name?> <?=Yii::$app->user->identity->last_name?></strong>

                             </span> <span class="text-muted text-xs block"><?=TaskController::getLoggedUserRole()?> 

                        </div>

                        <div class="logo-element">

                            CRM

                        </div>

                    </li>

                    <li class="<?=activeMenu('site/index')?>">

                        <a href="index.php?r=site/index"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span></a>

                      

                    </li>

					<?php

						$customer_menu=array('customer/customer/create','customer/customer/index');

					?>

                    <li class="<?= activeParentMenu($customer_menu)?>">

                        <a href="#"><i class="fa fa-users"></i> <span class="nav-label">Customers</span><span class="fa arrow"></span></a>

                        <ul class="nav nav-second-level">

                            <li class="<?=activeMenu('customer/customer/create')?>"><a href="index.php?r=customer/customer/create">Add Customer</a></li>

                            <li class="<?=activeMenu('customer/customer/index')?>"><a href="index.php?r=customer/customer/index">Manage Customers</a></li>

                        </ul>

                    </li>

                    <?php

						$project_menu=array('pmt/project/create','pmt/project/index');

					?>

                    <li class="<?= activeParentMenu($project_menu)?>">

                        <a href="#"><i class="fa fa-briefcase"></i> <span class="nav-label">Projects </span><span class="fa arrow"></span></a>

                        <ul class="nav nav-second-level">

                            <li class="<?=activeMenu('pmt/project/create')?>"><a href="index.php?r=pmt/project/create">Add Project</a></li>

                            <li class="<?=activeMenu('pmt/project/index')?>"><a href="index.php?r=pmt/project/index">Manage Projects</a></li>

                        </ul>

                    </li>

                    <?php

						$task_menu=array('pmt/task/create','pmt/task/my-tasks','pmt/task/index','pmt/task/task-view');

					?>

                    <li class="<?= activeParentMenu($task_menu)?>">

                        <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">Tasks</span><span class="fa arrow"></span></a>

                        <ul class="nav nav-second-level">

                            <li class="<?=activeMenu('pmt/task/create')?>"><a href="index.php?r=pmt/task/create">Add Tasks</a></li>

                            <li class="<?=activeMenu('pmt/task/my-tasks')?>"><a href="index.php?r=pmt/task/my-tasks">My Tasks</a></li>

                            <li class="<?=activeMenu('pmt/task/index')?>"><a href="index.php?r=pmt/task/index">Manage Tasks</a></li>

                        </ul>

                    </li>

                    <?php

						$pmt_menu=array('pmt/task/task-assignment-report','pmt/task/task-closed-reports','pmt/task/time-spent-report');

					?>

                    <li class="<?= activeParentMenu($pmt_menu)?>">

                        <a href="#"><i class="fa fa-bar-chart-o"></i> <span class="nav-label">Reports</span><span class="fa arrow"></span></a>

                        <ul class="nav nav-second-level">

                            <li  class="<?= activeParentMenu($pmt_menu)?>">

                                <a href="#">Project Management Reports<span class="fa arrow"></span></a>

                                <ul class="nav nav-third-level">\

									<!--

                                    <li>

                                        <a href="index.php?r=pmt/task/task-all-reports">All Reports</a>

                                    </li>

									-->

									 <li class="<?=activeMenu('pmt/task/task-assignment-report')?>">

                                        <a href="index.php?r=pmt/task/task-assignment-report">Task Assignments Report</a>

                                    </li>

									 <li class="<?=activeMenu('pmt/task/task-closed-reports')?>">

                                        <a href="index.php?r=pmt/task/task-closed-reports">Task Closed Report</a>

                                    </li>

									 <li class="<?=activeMenu('pmt/task/time-spent-report')?>">

                                        <a href="index.php?r=pmt/task/time-spent-report">Task Spent Time Report</a>

                                    </li>

                                   



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

        <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">

        <div class="navbar-header">

            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>

            <form role="search" class="navbar-form-custom" method="post" action="search_results.html">

                <div class="form-group">

                    <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">

                </div>

            </form>

        </div>

            <ul class="nav navbar-top-links navbar-right">

                <li>

                    <span class="m-r-sm text-muted welcome-message time_widget"></span>

                </li>

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

                <li class="dropdown">

                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">

                        <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>

                    </a>

                    <ul class="dropdown-menu dropdown-alerts">

                        <li>

                            <a href="mailbox.html">

                                <div>

                                    <i class="fa fa-envelope fa-fw"></i> You have 16 messages

                                    <span class="pull-right text-muted small">4 minutes ago</span>

                                </div>

                            </a>

                        </li>

                        <li class="divider"></li>

                        <li>

                            <a href="profile.html">

                                <div>

                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers

                                    <span class="pull-right text-muted small">12 minutes ago</span>

                                </div>

                            </a>

                        </li>

                        <li class="divider"></li>

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

                        </li>

                    </ul>

                </li>





                <li>

                    <a href="login.html">

                        <i class="fa fa-sign-out"></i> Log out

                    </a>

                </li>

            </ul>



        </nav>

        </div>

           

            <div class="wrapper wrapper-content">

                <div class="row">

                     <div class="col-lg-12">

					<!--<div class="container">-->

						<?php /* echo Breadcrumbs::widget ( [ 'links' => isset ( $this->params ['breadcrumbs'] ) ? $this->params ['breadcrumbs'] : [ ] ] ) */?>

						<?= $content?>

					<!--	</div>-->

                    </div>

                </div>

            </div>



        <div class="footer">

            <div class="pull-right">

                10GB of <strong>250GB</strong> Free.

            </div>

            <div>

                <strong>Copyright</strong> Example Company &copy; 2014-2015

            </div>

        </div>



        </div>

    </div>

<!-- Mainly scripts -->

    <!--<script src="js/jquery-2.1.1.js"></script>-->

	<?php $this->endBody()

		if(strpos($_GET['r'], 'my-calendar')===false){

	?>

<script src='../include/calendar/fullcalendar.min.js'></script>

		

	

    

    <?php } if($_GET['r']=='site/index'){?>

   	 <script src="js/bootstrap.min.js"></script>

    <?php }else{

		if(strpos($_GET['r'], 'index')===false){?>

			 <script src="js/bootstrap.min.js"></script>

	<?	}

	}?>

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

    <!--<script src="js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>

    <script src="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

-->

    <!-- Sparkline -->

    <!--<script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>-->



    <!-- Sparkline demo data  -->

   <!-- <script src="js/demo/sparkline-demo.js"></script>-->



    <!-- ChartJS-->

    <!--<script src="js/plugins/chartJs/Chart.min.js"></script>-->

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

