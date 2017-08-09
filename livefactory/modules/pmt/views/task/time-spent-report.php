<?php

setcookie('pagepath',$_GET['r'],time()+7200);

use yii\helpers\Html;



use yii\helpers\ArrayHelper;



use kartik\widgets\ActiveForm;



use kartik\builder\Form;



use kartik\datecontrol\DateControl;



use dosamigos\ckeditor\CKEditor;

use kartik\widgets\DatePicker;

use livefactory\modules\pmt\controllers\TaskController;

use livefactory\models\TimeDiffModel;

use livefactory\models\SendEmail;

$this->title =Yii::t ( 'app','Task Spent Time Reports');

error_reporting(0);

date_default_timezone_set('asia/kolkata');

function approved($val){

	if($val=='0')

	$label = "<span class=\"label label-warning\">Waiting for Approval</span>";

	else if($val=='1')

	$label = "<span class=\"label label-success\">Approved</span>";	

	else

	$label = "<span class=\"label label-danger\">Rejected</span>";	

	return $label;

}

function getTimeDiff($start,$end){

		$day=$hours=$minutes=0;

		$timing=explode(',',TimeDiffModel::dateDiff($end,$start));

		foreach($timing as $value){

			if(strpos($value,'day') !== false){

				$day=trim(str_replace('day','',$value));

			}

			if(strpos($value,'hours') !== false){

				$hours=trim(str_replace('hours','',$value));

			}

			if(strpos($value,'minutes') !== false){

				$minutes=trim(str_replace('minutes','',$value));

			}

		}

		$hours = ($day*24)+$hours;

		return $hours.".".$minutes;

	}

	$dates=array();

		if(!empty($_REQUEST['start_date']) && !empty($_REQUEST['end_date'])){

			$end_date=date('Y-m-d',strtotime($_REQUEST['end_date']));

			$start_date=date('Y-m-d',strtotime($_REQUEST['start_date']));

		}

		else if(!empty($_REQUEST['date']) && $_REQUEST['date'] =='last_month'){

			$start_date = date('Y-m-d',strtotime('first day of last month'));

			$end_date = date('Y-m-d',strtotime('last day of last month'));

			

		}else if(!empty($_REQUEST['date']) && $_REQUEST['date']=='last_week'){

			$start_date =date('Y-m-d',strtotime(date('Y-m-d',strtotime('last monday'))."- 7 days"));

			$end_date = date('Y-m-d',strtotime('last monday'));

			

		}else if(!empty($_REQUEST['date']) && $_REQUEST['date']=='this_week'){

			$end_date=date('Y-m-d',strtotime('+1 day'));

			$start_date=date('Y-m-d',strtotime('last monday'));

			

		}

		else{

			$end_date=date('Y-m-d',strtotime('+1 day'));

			$start_date=date('Y-m-d',strtotime('first day of this month'));

		}

		while($start_date != $end_date ){	

			$dates[]=$start_date;

			$start_date= date('Y-m-d',strtotime($start_date. "+1 days"));

			

			

		}

		//var_dump($data);

            $jSon = "[['Date',";

            $cm='';

                foreach($users as $user){

                    $jSon .=$cm. "'".$user."'";

                    $cm=',';	

                }

            $jSon .= "]";

            foreach($dates as $date){

                    $jSon.= ",['".$date."',";

                    $c='';

                    foreach($users as $key=>  $user){

                        $count=$data[$key][$date]==''?0:intval($data[$key][$date]);

                        $jSon.= $c.$count;

                        $c=',';

                    }

                    $jSon .= "]";

                }

                $jSon.="]";

           //   echo $jSon;

	/*echo "<pre>";

	var_dump($data);

	echo "</pre>";*/

?>

<script src="../include/jquery.js"></script>

<link rel="stylesheet" href="../include/jPages.css">



<script type="text/javascript">

function Add_Error(obj,msg){

	 $(obj).parents('.form-group').addClass('has-error');

	 $(obj).parents('.form-group').append('<div style="color:#D16E6C; clear:both" class="error"><i class="icon-remove-sign"></i> '+msg+'</div>');

	 return true;

}

function Remove_Error(obj){

	$(obj).parents('.form-group').removeClass('has-error');

	$(obj).parents('.form-group').children('.error').remove();

	return false;

}

$(document).ready(function(e) {

	

   $('.search').click(function(event){

			

				error='';

				Remove_Error($('#end_date'));

				

				var actual_start = $('#start_date').val();

				var actual_end = $('#end_date').val();

				var startTime = new Date(actual_start);

				var endTime = new Date(actual_end);

				if(startTime>endTime){

					 error+=Add_Error($('#end_date'),'Start Time Should be Less then End Time');

				}else{

					Remove_Error($('#end_date'));

				}

				if(error !=''){

					event.preventDefault();

					return false;

				}else{

					return true;

				}

	}) 

});



</script>

<script>

	$(document).ready(function(e) {

	$("div.holder").jPages({

      containerID : "movies",

      perPage : 3,

      delay : 20

    });

        

    });

	</script>

    <div class="row">

    <div class="col-sm-6">

    	<div class="holder"></div>

    </div>

    <div class="col-sm-6">

        <div class="pull-right">

        <form action="" method="post">

         <?php Yii::$app->request->enableCsrfValidation = true; ?>

            <input type="hidden" name="_csrf" value="<?php echo $this->renderDynamic('return Yii::$app->request->csrfToken;'); ?>">

        <div class="row">

            <div class="col-sm-5">

                <div class="form-group">

                             <?php

                echo '<label class="control-label">Start Date</label>';echo DatePicker::widget([    'name' => 'start_date','id'=>'start_date',    'type' => DatePicker::TYPE_COMPONENT_PREPEND,    'value' => $_REQUEST[start_date],    'pluginOptions' => [        'autoclose'=>true,        'format' => 'yyyy/mm/dd'    ]]);

                ?>

                </div>

            </div>

            <div class="col-sm-5">

                <div class="form-group">

                       <?php

        echo '<label class="control-label">End Date</label>';echo DatePicker::widget([    'name' => 'end_date', 'id'=>'end_date',   'type' => DatePicker::TYPE_COMPONENT_PREPEND,    'value' => $_REQUEST[end_date],    'pluginOptions' => [        'autoclose'=>true,        'format' => 'yyyy/mm/dd'    ]]);

        

        ?>

                </div>

            </div>

            <div class="col-sm-2">

                    <label class="control-label" style="color:#fff;"><?=Yii::t ( 'app','Search')?></label>

                <div class="form-group">

                      <input type="submit" value="<?=Yii::t ( 'app','Search')?>" class="btn btn-success search">

                </div>

            </div>

        </div>

        </form>

        </div>

     </div>

</div>

<div class="panel panel-info">

	<div class="panel-heading">

    	<h3 class="panel-title">

        	<?=Yii::t ( 'app','Task Time Spent Report')?>

            <div class="pull-right">

            	<a href="index.php?r=pmt/task/time-spent-report&date=last_month" class="btn btn-default btn-xs">

                

                	<?=Yii::t ( 'app','Last Month')?>

                </a>

                <a href="index.php?r=pmt/task/time-spent-report&date=this_month" class="btn btn-default btn-xs">

                	<?=Yii::t ( 'app','This Month')?>

                </a>

                <a href="index.php?r=pmt/task/time-spent-report&date=last_week" class="btn btn-default btn-xs">

                	<?=Yii::t ( 'app','Last Week')?>

                </a>

                <a href="index.php?r=pmt/task/time-spent-report&date=this_week" class="btn btn-default btn-xs">

                	<?=Yii::t ( 'app','This Week')?>

                </a>

                

            </div>

        </h3>

    </div>

    	

    <div class="panel-body">

    	<div class="col-sm-7">

    	<?php if(count($dataProvider) > 0){ ?>

         <table class="table table-bordered table-striped">

            <thead>

            <tr>

                <th><?=Yii::t ( 'app','User')?></th>

                <th><?=Yii::t ( 'app','Project')?></th>

                <th><?=Yii::t ( 'app','Task')?></th>

                <th><?=Yii::t ( 'app','Type')?></th>

                <th><?=Yii::t ( 'app','Time Spent')?></th>

                <th><?=Yii::t ( 'app','Approved')?></th>

            </tr>

            </thead>

            <tbody id="movies">

        <?php foreach($dataProvider as $row){ ?>

            <tr>

            	<td><?=$row['first_name']?></td>

                <td><a href="index.php?r=pmt/project/project-view&id=<?=$row['pid']?>"><?=$row['project_name']?></a></td>

                <td><a href="index.php?r=pmt/task/task-view&id=<?=$row['tid']?>"><?=$row['task_id']?>-<?=$row['task_name']?></a></td>

                <td><?=$row['entry_type']?></td>

                <td><?=TimeDiffModel::dateDiff($row['end_time'],$row['start_time']);?></td>

                <td><?=approved($row['approved'])?></td>

            </tr>

        <?php } 

        $spend_t=0;

        $dotNumTot=0;

        $solidNumTot=0;

        foreach($dataProvider as $trow1){

            list($solidNum,$dotNum) = explode('.',getTimeDiff(date('Y/m/d H:i:s',strtotime($trow1['start_time'])),date('Y/m/d H:i:s',strtotime($trow1['end_time']))));

            $solidNumTot+=$solidNum;

            $dotNumTot+=$dotNum;

        }

        list($plusNum)=explode('.',$dotNumTot/60);;

        $dotVal=round($dotNumTot%60);

        $solidNum =$solidNumTot+$plusNum;

        $spend_t=$solidNum." hours, ".$dotVal." minutes";

        ?>

        </tbody>

        <tr>

            <td colspan="6" align="right">

                <strong><?=Yii::t ( 'app','Total Spent Time')?> : <?=$spend_t?></strong>

            </td>

        </tr>

        </table>

        <?php }else{

			echo Yii::t ( 'app',"no result");

		}?>

        </div>

        <div class="col-sm-5">

        <?php if(count($dataProvider) > 0){ ?>

        	<div id="taskTiming"></div>

            <?php } ?>

        </div>

    </div>

    





</div>

 <script src="../include/jsapi.js"></script>

<script type="text/javascript">

            google.load("visualization", "1", {packages:["corechart"]});

            google.setOnLoadCallback(drawChart);

            function drawChart() {

                var data = google.visualization.arrayToDataTable(<?=$jSon ?>);

                var options = {

                legend: { position: 'top', maxLines: 3 },

                bar: { groupWidth: '75%' },

                isStacked: true,

                fontSize:'10',

              };

            //var chart = new google.visualization.LineChart(document.getElementById('customer-months'));

            var chart = new google.visualization.ColumnChart(document.getElementById('taskTiming'));

            chart.draw(data, options);

            }

            </script>





