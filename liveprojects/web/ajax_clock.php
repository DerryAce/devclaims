<?php
error_reporting(0);
$to = $_REQUEST['to'];
date_default_timezone_set('Asia/Kolkata');
$datetime1 = new \DateTime(date('Y/m/d H:i:s',strtotime($_COOKIE['start_time'])));
		$datetime2 = new \DateTime(date('Y/m/d H:i:s'));
		$interval = $datetime1->diff($datetime2);
		$elapsed = $interval->format('%H.%I');
		//if($second)
			$elapsed = $interval->format('%H.%I.%S');
		echo  $elapsed;
		?>