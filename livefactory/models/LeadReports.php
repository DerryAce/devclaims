<?php

namespace livefactory\models;
use livefactory\models\AssignmentHistory;
use Yii;
use yii\filters\VerbFilter;
use yii\db\Query;
use livefactory\models\Lead as LeadModel;
class LeadReports extends \yii\db\ActiveRecord
{
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '';
    }
	public function init(){
		error_reporting(0);
	}
    public static  function myLeadStatusChart($id){
	$query = LeadModel::find()->select("lot_lead_status.label,count(lot_lead.id) statuscount")->joinWith('leadStatus')->groupBy('lead_status_id')->where("assigned_user_id=".Yii::$app->user->identity->id)->asArray()->all();

$xaxis = "[['Lead ', 'Lead Status']";
foreach ($query as $row_lead_status) 
{
	$xaxis.=",['".$row_lead_status['label']."', ".intval($row_lead_status['statuscount'])."]";
}
$xaxis.="]";
//echo $xaxis;
?>
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable(<?=$xaxis?>);

        var options = {
          title: '',
		 pieHole: 0.3,
        };

        var chart = new google.visualization.PieChart(document.getElementById('<?=$id?>'));
        chart.draw(data, options);
      }
    </script>
<?php }
	
	
	public  function leadStatusCounting($user,$type){
		$leadTypes = LeadModel::find()->select("lot_lead_status.label,count(lot_lead.id) statuscount")->joinWith('leadStatus')->groupBy('lead_status_id')->where("assigned_user_id=".$user." and lead_status_id=".$type)->asArray()->one();
		return $leadTypes['statuscount']==''?0:$leadTypes['statuscount'];
	}
	
	public function getLeadAssignmentChart($id){
		$users = LeadModel::find()->joinWith('user')->groupBy('assigned_user_id')->asArray()->all();
		$user2d='';
		//user array
		foreach($users as $usrs){
				if(!empty($usrs['user']['id']))
				$user2d[$usrs['user']['id']]=$usrs['user']['first_name']." ".$usrs['user']['last_name'];
		}
		// lead status
		$leadTypes = LeadModel::find()->select("lot_lead_status.label,lot_lead_status.id")->joinWith('leadStatus')->groupBy('lead_status_id')->where('lead_status_id not in(2,6)')->asArray()->all();
$jSon = "[['User',";
$cm='';
	foreach($leadTypes as $status){
		$jSon .=$cm. "'".$status['label']."'";
		$cm=',';	
	}
$jSon .= "]";
		foreach($user2d as $key => $user){
			$jSon.= ",['".$user."',";
			$c='';
			foreach($leadTypes as $status){
				$jSon.= $c.$this->leadStatusCounting($key,$status['id']);
				$c=',';
			}
			$jSon .= "]";
		}
		$jSon.="]";
		//var_dump($jSon);
	?>
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
	var chart = new google.visualization.ColumnChart(document.getElementById('<?=$id?>'));
	chart.draw(data, options);
	}
    </script>
  <?php }
  public static  function getTimeDiff($start,$end){
		$hours=$minutes=0;
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
			if(strpos($value,'minute') !== false){
				$minutes=trim(str_replace('minute','',$value));
			}
		}
		$hours = ($day*24)+$hours;
		return $hours.".".$minutes;
	}
  public static  function getTotalUserSpentTime($uid,$date){
	  $sql="select lot_time_entry.* from lot_time_entry,lot_lead where lot_lead.assigned_user_id='$uid' and lot_lead.id=lot_time_entry.entity_id and date(start_time)='$date'";
	  $connection = \Yii::$app->db;
	  $command=$connection->createCommand($sql);
	  $dataReader=$command->queryAll();
					
		$spend_t=0;
		$dotNumTot=0;
		$solidNumTot=0;
		foreach($dataReader as $trow1){
			list($solidNum,$dotNum) = explode('.',$this->getTimeDiff(date('Y/m/d H:i:s',strtotime($trow1['start_time'])),date('Y/m/d H:i:s',strtotime($trow1['end_time']))));
			$solidNumTot+=$solidNum;
			$dotNumTot+=$dotNum;
		}
		list($plusNum)=explode('.',$dotNumTot/60);;
		$dotVal=round($dotNumTot%60);
		$solidNum =$solidNumTot+$plusNum;
		$dotVal=strlen($dotVal)==1?"0".$dotVal:$dotVal;
		$solidNum=strlen($solidNum)==1?"0".$solidNum:$solidNum;
		$spend_t=$solidNum.".".$dotVal;
  }
  /*public static  function getleadCloseChart($start,$end){
	  
  }*/
}
