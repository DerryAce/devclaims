<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use kartik\widgets\ActiveForm;

use dosamigos\ckeditor\CKEditor;
use kartik\builder\Form;
use livefactory\modules\pmt\controllers\TaskController;
use livefactory\models\SendEmail;
$emailObj = new SendEmail;
$subject='';
include_once(__DIR__ .'/../../../../../vendor/swiftmailer/swiftmailer/lib/swift_required.php');

//require_once 'lib/swift_required.php';
//$taskModel = new TaskController;
	foreach($dataProvider as $project){
	$toEmail = TaskController::getProjectOwnerEmail($project['id']);
	$subject='Work Summary Project '.$project['project_name'];
    $body ='Hi '.$project['first_name']." ".$project['last_name']."<br/>";
	$body.="Please find below summary report for $project[project_name]<br/>";
	$body.="Total Opened Tasks - "; 
	$body.=count(TaskController::getNeedActions($project['id']))+count(TaskController::getInprocessTasks($project['id']));
	$body.='<h3>Need Actions</h3>
    <table width="100%" cellpadding="5" style="border-collapse:collapse">
    	<tr>
        	<th style="padding:5px; border:1px solid #ccc;">Task Name</th>
            <th style="padding:5px; border:1px solid #ccc;">User</th>
            <th style="padding:5px; border:1px solid #ccc;">Expected Start Date</th>
            <th style="padding:5px; border:1px solid #ccc;">Expected End Date</th>
        </tr>';
       
			if(count(TaskController::getNeedActions($project['id'])) >0 ){
				foreach(TaskController::getNeedActions($project['id']) as $taskNeed){
	
        $body.='<tr>
        	<td style="padding:5px; border:1px solid #ccc;">'.$taskNeed[task_name].'</td>
            <td style="padding:5px; border:1px solid #ccc;">'.$taskNeed[user][first_name].'</td>
            <td style="padding:5px; border:1px solid #ccc;">'.$taskNeed[expected_start_datetime].'</td>
            <td style="padding:5px; border:1px solid #ccc;">'.$taskNeed[expected_end_datetime].'</td>
         </tr>';
			} 
		}else{
			$body.="<tr style='padding:5px; border:1px solid #ccc;'><td>No Result</td></tr>";	
		}
    $body.='</table>
    <hr/>
		<h3>Inprocess Tasks</h3>
        <table width="100%" cellpadding="5" style="border-collapse:collapse">
            <tr>
                <th style="padding:5px; border:1px solid #ccc;">Task Name</th>
                <th style="padding:5px; border:1px solid #ccc;">User</th>
                <th style="padding:5px; border:1px solid #ccc;">Expected Start Date</th>
                <th style="padding:5px; border:1px solid #ccc;">Expected End Date</th>
            </tr>';
		 	if(count(TaskController::getInprocessTasks($project['id'])) >0 ){
                foreach(TaskController::getInprocessTasks($project['id']) as $taskNeed){
            $body.='<tr>
                <td style="padding:5px; border:1px solid #ccc;">'.$taskNeed['task_name'].'</td>
                <td style="padding:5px; border:1px solid #ccc;">'.$taskNeed['user']['first_name'].'</td>
                <td style="padding:5px; border:1px solid #ccc;">'.$taskNeed['expected_start_datetime'].'</td>
                <td style="padding:5px; border:1px solid #ccc;">'.$taskNeed['expected_end_datetime'].'</td>
            </tr>';
              } 
			}else{
			$body.= "<tr style='padding:5px; border:1px solid #ccc;'><td>No Result</td></tr>";	
		}
		$body.='</table>
    <hr/>
		<h3>Week Tasks</h3>
        <table width="100%" cellpadding="5" style="border-collapse:collapse">
            <tr>
                <th style="padding:5px; border:1px solid #ccc;">Task Name</th>
                <th style="padding:5px; border:1px solid #ccc;">User</th>
                <th style="padding:5px; border:1px solid #ccc;">Actual Start Date</th>
                <th style="padding:5px; border:1px solid #ccc;">Actual End Date</th>
            </tr>';
            
				if(count(TaskController::getWeakClosedTasks($project['id'])) >0 ){
                foreach(TaskController::getWeakClosedTasks($project['id']) as $taskNeed){
            $body.='<tr>
                <td style="padding:5px; border:1px solid #ccc;">'.$taskNeed['task_name'].'</td>
                <td style="padding:5px; border:1px solid #ccc;">'.$taskNeed['user']['first_name'].'</td>
                <td style="padding:5px; border:1px solid #ccc;">'.$taskNeed['actual_start_datetime'].'</td>
                <td style="padding:5px; border:1px solid #ccc;">'.$taskNeed['actual_end_datetime'].'</td>
            </tr>';
              } 
			}else{
			$body.= "<tr style='padding:5px; border:1px solid #ccc;'><td>No Result</td></tr>";	
		}
		$body.='</table>
    <hr/>
		<h3>Month Tasks</h3>
        <table width="100%" cellpadding="5" style="border-collapse:collapse">
            <tr>
                <th style="padding:5px; border:1px solid #ccc;">Task Name</th>
                <th style="padding:5px; border:1px solid #ccc;">User</th>
                <th style="padding:5px; border:1px solid #ccc;">Actual Start Date</th>
                <th style="padding:5px; border:1px solid #ccc;">Actual End Date</th>
            </tr>';
            
			if(count(TaskController::getMonthClosedTasks($project['id'])) >0 ){
                foreach(TaskController::getMonthClosedTasks($project['id']) as $taskNeed){
           
            $body.='<tr>
                <td style="padding:5px; border:1px solid #ccc;">'.$taskNeed['task_name'].'</td>
                <td style="padding:5px; border:1px solid #ccc;">'.$taskNeed['user']['first_name'].'</td>
                <td style="padding:5px; border:1px solid #ccc;">'.$taskNeed['actual_start_datetime'].'</td>
                <td style="padding:5px; border:1px solid #ccc;">'.$taskNeed['actual_end_datetime'].'</td>
            </tr>';
            } 
			}else{
			$body.="<tr style='padding:5px; border:1px solid #ccc;'><td>No Result</td></tr>";	
		}
        $body.='</table>';
		// Create the mail transport configuration
		$transport = Swift_MailTransport::newInstance();
		 
		// Create the message
		$message = Swift_Message::newInstance();
		$message->setTo(array(
		  "kabir.mufiz49@gmail.com",
		  $toEmail
		));
		$message->setSubject($subject);
		$message->setContentType("text/html");
		$message->setBody($body);
		$message->setFrom("contact@liveobjects.org", "Live Objects");
		 
		// Send the email
		$mailer = Swift_Mailer::newInstance($transport);
		$mailer->send($message);
 //$emailObj->emailSendMethod($toEmail, $body, $cc = false, $subject); 
} ?>