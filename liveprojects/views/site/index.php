<?php
use livefactory\models\search\CommonModel;

/* @var $this yii\web\View */
$this->title = \Yii::t('app', 'My Dashboard');
$days=cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));
$par=(CommonModel::getTotalClosedTask()/CommonModel::getTotalOpenTask())*100;
if(CommonModel::getTotalClosedTask()>CommonModel::getTotalOpenTask()){
	$max=CommonModel::getTotalClosedTask();
}else{
	$max=CommonModel::getTotalOpenTask();
}
//200/300*100
for($i=1;$i<=$days;$i++){
	$date=date('Y-m-').$i;
	$closedTask[$i]=CommonModel::getClosedTask($date);
}
for($i=1;$i<=$days;$i++){
	$date=date('Y-m').'-'.$i;
	$openedTask[$i]=CommonModel::getOpenedTask($date);
}
for($i=1;$i<=12;$i++){
	$openedMonthlyTask[$i]=CommonModel::getOpenedMonthlyTask(date('Y'),$i);
}
for($i=1;$i<=12;$i++){
	$closedMonthlyTask[$i]=CommonModel::getClosedMonthlyTask(date('Y'),$i);
}
//var_dump($closedTask);
foreach(CommonModel::getAllTaskYears() as $yearRow){
	if(strlen($yearRow['year_name'])>3)
	$allYears[]=$yearRow['year_name'];
}
array_push($allYears,2009,2010,2011,2012,2013,2014,2015,2016,2017);
sort($allYears);
for($i=0;$i<count($allYears);$i++){
	$openedYearlyTask[$i]=CommonModel::getOpenedYearlyTask($allYears[$i]);
}
for($i=0;$i<count($allYears);$i++){
	$closedYearlyTask[$i]=CommonModel::getClosedYearlyTask($allYears[$i]);
}
?>
<?php
$customers='';
$check=array();
	foreach(CommonModel::getCustomers() as $cusRow){
		
		if(!in_array($cusRow['country_code'],$check)){
			$customers.='"'.$cusRow['country_code'].'":1,';	
		}
		$check[]=$cusRow['country_code'];
	}
	//var_dump($customers);
	
?>
<script src="../include/jquery.js"></script>
<link rel="stylesheet" href="../include/jPages.css">
<script>
	$(document).ready(function(e) {
	$("div.holder").jPages({
      containerID : "todolist",
      perPage : 15,
      delay : 20
    });
	$("div.holder1").jPages({
      containerID : "timeline",
      perPage : 6,
      delay : 20
    });
	$("div.holder2").jPages({
      containerID : "customers",
      perPage : 6,
      delay : 20
    });
       $('#project_box').change(function(){
		 	window.location.href='index.php?r=site/index&entity_id='+$(this).val()+'#timeline';
	   })
    });
</script>
<div class="site-index">
	<div class="row">
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-success pull-right">this month</span>
                        <h5><?php echo Yii::t('app', 'Incidents'); ?></h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><?=CommonModel::getTotalOpenTask()?></h1>
                        <div class="stat-percent font-bold text-success"><?=ceil((CommonModel::getTotalDoneTask()/CommonModel::getTotalOpenTask())*100)?>% <i class="fa fa-bolt"></i></div>
                        <small><?php echo Yii::t('app', 'Total Incidents'); ?></small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-info pull-right"><?php echo Yii::t('app', 'this month'); ?></span>
                        <h5><?php echo Yii::t('app', 'Closed Incidents'); ?></h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><?=CommonModel::getTotalDoneTask()?></h1>
                        <div class="stat-percent font-bold text-info">100% <i class="fa fa-level-up"></i></div>
                        <small><?php echo Yii::t('app', 'Closed Incidents'); ?></small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-warning pull-right"><?php echo Yii::t('app', 'this month'); ?></span>
                        <h5><?php echo Yii::t('app', 'Pending Incidents'); ?></h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><?=CommonModel::getTotalPenddingTask()?></h1>
                        <div class="stat-percent font-bold text-navy text-warning">100% <i class="fa fa-level-down"></i></div>
                        <small><?php echo Yii::t('app', 'Total Pending Incidents'); ?></small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <span class="label label-danger pull-right"><?php echo Yii::t('app', 'this month'); ?></span>
                        <h5><?php echo Yii::t('app', 'Cancelled Incidents'); ?></h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins"><?=CommonModel::getTotalCancelledTask()?></h1>
                        <div class="stat-percent font-bold text-danger">100% <i class="fa fa-level-down"></i></div>
                        <small><?php echo Yii::t('app', 'Total Cancelled Incidents'); ?></small>
                    </div>
                </div>
            </div>
        </div>
	<div class="ibox-content" style="padding:0">
    	 <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?php echo Yii::t('app', 'Incidents Open'); ?> / <?php echo Yii::t('app', 'Closed'); ?></h5>
                        <div class="pull-right">
                            <div class="btn-group">
                                <a href="index.php?r=site/index&task_report=daily" class="btn btn-xs btn-white <?= $_GET['task_report']==''?'active':($_GET['task_report']=='daily'?'active':'')?>"><?php echo Yii::t('app', 'Daily'); ?></a>
                                <a href="index.php?r=site/index&task_report=monthly" class="btn btn-xs btn-white  <?= $_GET['task_report']=='monthly'?'active':''?>"><?php echo Yii::t('app', 'Monthly'); ?></a>
                                <a href="index.php?r=site/index&task_report=yearly" class="btn btn-xs btn-white  <?= $_GET['task_report']=='yearly'?'active':''?>"><?php echo Yii::t('app', 'Annual'); ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="padding:7px">
                        <div class="col-lg-9">
                            <div class="flot-chart">
                                <div class="flot-chart-content" id="flot-dashboard-chart"></div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <ul class="stat-list">
                                <li>
                                    <h2 class="no-margins"><?php echo Yii::t('app', 'Total Open'); ?> <span class="badge badge-info pull-right"><?=CommonModel::getTotalClosedTask()?></span></h2>
                                    <small><?php echo Yii::t('app', 'Total Closed Incidents'); ?></small>
                                    <div class="stat-percent"><?=round($par, 2)?>% <i class="fa fa-level-up text-navy"></i></div>
                                    <div class="progress progress-mini">
                                        <div style="width:<?=$par?>%;" class="progress-bar"></div>
                                    </div>
                                </li>
                                <!--<li>
                                    <h2 class="no-margins ">4,422</h2>
                                    <small>Orders in last month</small>
                                    <div class="stat-percent">60% <i class="fa fa-level-down text-navy"></i></div>
                                    <div class="progress progress-mini">
                                        <div style="width: 60%;" class="progress-bar"></div>
                                    </div>
                                </li>
                                <li>
                                    <h2 class="no-margins ">9,180</h2>
                                    <small>Monthly income from orders</small>
                                    <div class="stat-percent">22% <i class="fa fa-bolt text-navy"></i></div>
                                    <div class="progress progress-mini">
                                        <div style="width: 22%;" class="progress-bar"></div>
                                    </div>
                                </li>-->
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
         
    </div>
    <br/><br/>
    <div class="row">
     	<div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><?php echo Yii::t('app', 'Clients Worldwide'); ?></h5>
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

                            <div class="row">
                                <div class="col-lg-6">
                                    <table class="table table-hover margin bottom">
                                        <thead>
                                        <tr>
                                            <th style="width: 1%" class="text-center"><?php echo Yii::t('app', 'No.'); ?></th>
                                            <th><?php echo Yii::t('app', 'Client Name'); ?></th>
                                            <th class="text-center"><?php echo Yii::t('app', 'Date'); ?></th>
                                            <th class="text-center"><?php echo Yii::t('app', 'Country'); ?></th>
                                        </tr>
                                        </thead>
                                        <tbody id="customers">
                                        <?php
											$i=0;
											foreach(CommonModel::getCustomerList() as $c_row){
												$i++;
										?>
                                        <tr>
                                            <td class="text-center"><?=$i?></td>
                                            <td><a style="color:#1ab394" href="index.php?r=customer/customer/customer-view&id=<?=$c_row['id']?>"><?=$c_row['first_name']." ".$c_row['last_name']?></a></td>
                                            <td class="text-center small"><?=date('F d,Y',$c_row['created_at'])?></td>
                                            <td class="text-center"><span class="label label-primary"><?=$c_row['country']?></span></td>

                                        </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                    <div class="holder holder2"></div>
                                </div>
                                <div class="col-lg-6">
                                    <div id="world-map" style="height: 300px;"></div>
                                </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
     </div>
    <div class="row">
        <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title" style="padding-top:7px">
                        <h5><?php echo Yii::t('app', 'Claims Timeline'); ?></h5>
                        <div class="col-sm-7 pull-right">
                        <select class="form-control" id="project_box">
                            	<?php foreach(CommonModel::getAllProject() as $projects){?>
								<option value="<?=$projects['id']?>" <?=$projects['id']==$_GET['entity_id']?'selected':''?>><?=$projects['project_name']?></option>	
								<?php }?>
                            </select>
                        </div>
                        <!--<span class="label label-primary">Meeting today</span>-->
                        <!--<div class="ibox-tools">
                        	
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#">Config option 1</a>
                                </li>
                                <li><a href="#">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>-->
                    </div>

                    <div class="ibox-content inspinia-timeline" id="timeline">
						<?php
							foreach(CommonModel::getTimeLine() as $timeline){
						?>
                        <div class="timeline-item">
                            <div class="row">
                                <div class="col-xs-3 date">
                                    <i class="fa fa-briefcase"></i>
                                    <?= date('F d,Y',$timeline['added_at'])?>
                                </div>
                                <div class="col-xs-7 content no-top-border">
                                    <!--<p><strong><?= $timeline['project_name']?></strong></p>-->
                                    <p><?= $timeline['notes']?></p>

                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="holder holder1"></div>
                </div>
            </div>
        <div class="col-lg-6">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5><?php echo Yii::t('app', 'Todo list'); ?></h5>
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
                                        <ul class="todo-list m-t small-list" id="todolist">
                                        	<?php
												foreach(CommonModel::getToDo() as $task){
											?>
                                            <li>
                                                <a href="index.php?r=pmt/task/task-view&id=<?=$task['id']?>" class="check-link" style="font-size:13px"><i class="fa   <?=$task['task_status_id']=='2'?'fa-check-square':'fa-check-square-o'?>"></i> 
                                                <span class="m-l-xs  <?=$task['task_status_id']=='2'?'todo-completed':''?>"><?=$task['task_name']?></span>
                                                </a>

                                            </li>
                                            <?php } ?>
                                        </ul>
                                        <div class="holder"></div>
                                    </div>
                                </div>
                            </div>
     </div>
     
    <!--<div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div>-->
</div>

<script>
var closedTask = <?php echo json_encode($closedTask) ?>;
var openedTask = <?php echo json_encode($openedTask) ?>;
var closedMonthlyTask = <?php echo json_encode($closedMonthlyTask) ?>;
var openedMonthlyTask = <?php echo json_encode($openedMonthlyTask) ?>;
var allYear = <?php echo json_encode($allYears) ?>;
var closedYearlyTask = <?php echo json_encode($closedYearlyTask) ?>;
var openedYearlyTask = <?php echo json_encode($openedYearlyTask) ?>;
var days =<?=$days?>;
var d=new Date();
        $(document).ready(function() {
			var mapData = {<?=$customers?>};

            $('#world-map').vectorMap({
                map: 'world_mill_en',
                backgroundColor: "transparent",
                regionStyle: {
                    initial: {
                        fill: '#e4e4e4',
                        "fill-opacity": 0.9,
                        stroke: 'none',
                        "stroke-width": 0,
                        "stroke-opacity": 0
                    }
                },

                series: {
                    regions: [{
                        values: mapData,
                        scale: ["#1ab394", "#22d6b1"],
                        normalizeFunction: 'polynomial'
                    }]
                },
            });
		})
</script>
<?php if($_GET['task_report']=='yearly'){?>
	<script src="../include/yearlyTask.js"></script>
<?php }else if($_GET['task_report']=='monthly'){?>
	<script src="../include/monthTask.js"></script>
<?php }else{ ?>
	<script src="../include/dailyTask.js"></script>
<?php } ?>