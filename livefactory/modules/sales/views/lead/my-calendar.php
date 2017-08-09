<?php

$this->title = Yii::t ( 'app', 'My Calendar');

$jSon="[";

$coma='';

foreach($dataProvider as $row){

	if(strtotime($row['expected_end_datetime']) < strtotime(date('Y-m-d')) and $row['lead_status_id'] !=2){

		$color='#F00';	

	}else if($row['lead_status_id'] ==2){

		$color='#090';	

	}else{

		$color='#F90';

	}

	$jSon.=$coma."{'id':'".$row['id']."','color':'".$color."','title':'".$row['lead_title']."','start':'".$row['expected_start_datetime']."','end':'".$row['expected_end_datetime']."','url':'index.php?r=sales/lead/lead-view&id=".$row['id']."'}";

	$coma=",";

 } 

$jSon.="]"; 

//echo $jSon;

 ?>

 <script src="../include/jquery.js"></script>

<link href='../include/calendar/fullcalendar.css' rel='stylesheet' />

<link href='../include/calendar/fullcalendar.print.css' rel='stylesheet' media='print' />

 <script src='../include/calendar/lib/moment.min.js'></script>

<script>



	$(document).ready(function() {

		

		$('#calendar').fullCalendar({

			header: {

				left: 'prev,next today',

				center: 'title',

				right: 'month,agendaWeek,agendaDay'

			},

			editable: true,

			eventLimit: true, // allow "more" link when too many events

			events:<?=$jSon?>

		});

		

	});



</script>

<div class="panel panel-info">

	<div class="panel-heading">

    	<h3 class="panel-title"><?=$this->title?></h3>

    </div>

    <div class="panel-body">

    	<div id='calendar'></div>

    </div>

</div>

	

