<?php

namespace livefactory\models;
use livefactory\models\AssignmentHistory;
use Yii;
use yii\filters\VerbFilter;
use yii\db\Query;
use livefactory\models\Customer as CustomerModel;
class CustomerReport extends \yii\db\ActiveRecord
{
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '';
    }
	public function getTotalCustomerType($month,$year,$type){
		$sql = "SELECT count(lot_customer.id) tot, lot_customer_type.type type FROM lot_customer,lot_customer_type where lot_customer.customer_type_id=lot_customer_type.id and from_unixtime(lot_customer.created_at, '%m') ='$month' and from_unixtime(lot_customer.created_at, '%Y') ='$year' and  lot_customer_type.type='$type'   group by  lot_customer.customer_type_id ";
		$connection = \Yii::$app->db;
		$command=$connection->createCommand($sql);
		$row=$command->queryOne();
		return $row['tot']?$row['tot']:0;
	} 
    public function getNewCustomerWithTypeChat($id){
	$month = time();
	for ($i = 1; $i <= 12; $i++) {
		if($i==1)
	  $month = strtotime(date('M', $month), $month);
	  else
	   $month = strtotime('last month', $month);
	  $months[] = date("Y-m-d", $month);
	}
	$months=array_reverse($months);
	$sql = "SELECT count(lot_customer.id) tot, lot_customer_type.type type FROM lot_customer,lot_customer_type where lot_customer.customer_type_id=lot_customer_type.id group by  lot_customer.customer_type_id ";
	$connection = \Yii::$app->db;
	$command=$connection->createCommand($sql);
	$dataReader=$command->queryAll();
	$jSon = "[['Year',";
	$cm='';
	$typeArray;
	foreach($dataReader as $cr){
		$typeArray[]=$cr['type'];
		$jSon .=$cm. "'".$cr['type']."'";
		$cm=',';
	}
	$jSon .= "]";
	for ($i=0;$i<count($months);$i++) 
	{
		$jSon.= ",['".date('M',strtotime($months[$i]))."-".date('Y',strtotime($months[$i]))."',";
		$c='';
		foreach ($typeArray as $tp) 
		{
			$jSon.= $c.$this->getTotalCustomerType(date('m',strtotime($months[$i])),date('Y',strtotime($months[$i])),$tp);
			$c=',';
		}
		$jSon .= "]";
	}
$jSon.="]";
//echo $jSon;
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
	 public function getTotalCustomers($month,$year){
	$sql = "SELECT * FROM lot_customer WHERE  from_unixtime(created_at, '%m') ='$month' and from_unixtime(created_at, '%Y') ='$year' ";
	$connection = \Yii::$app->db;
	$command=$connection->createCommand($sql);
	$dataReader=$command->queryAll();
	return count($dataReader);
}
	public function newCustomerChart($id){
	$month = time();
		for ($i = 1; $i <= 12; $i++) {
			if($i==1)
		  $month = strtotime(date('M', $month), $month);
		  else
		   $month = strtotime('last month', $month);
		  $months[] = date("Y-m-d", $month);
		}
		$months=array_reverse($months);
	$jSon = "[['Year', 'Month']";
	for ($i=0;$i<count($months);$i++) 
	{
		$jSon.= ",['".date('M',strtotime($months[$i]))."-".date('Y',strtotime($months[$i]))."',".$this->getTotalCustomers(date('m',strtotime($months[$i])),date('Y',strtotime($months[$i])))."]";
	}
	$jSon.="]";
	?>
    <script type="text/javascript">
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);
	function drawChart() {
		var data = google.visualization.arrayToDataTable(<?=$jSon ?>);
		var options = {
		title: '',
		fontSize:'10',
		//hAxis: {title: 'Year', titleTextStyle: {color: 'red'}},
	};
	//var chart = new google.visualization.LineChart(document.getElementById('customer-months'));
	var chart = new google.visualization.ColumnChart(document.getElementById('<?=$id?>'));
	chart.draw(data, options);
	}
    </script>
   <?php }
   public function customerTypeChart($id){
	   $sql = "SELECT cus.*,type.type customer_type,count(cus.id) typecount from lot_customer cus,lot_customer_type type where type.id=cus.customer_type_id 
	GROUP BY cus.customer_type_id";
	
	$connection = \Yii::$app->db;
	$command=$connection->createCommand($sql);
	$dataReader=$command->queryAll();
	$ctype = "[['Customer Type', 'Customer Type']";
	foreach($dataReader as $row_customer_type) 
	{
		$ctype.=",['".$row_customer_type['customer_type']."', ".intval($row_customer_type['typecount'])."]";
	}
	$ctype.="]";
	?>
	<script type="text/javascript">
		  google.load("visualization", "1", {packages:["corechart"]});
		  google.setOnLoadCallback(drawChart);
		  function drawChart() {
			var data = google.visualization.arrayToDataTable(<?=$ctype?>);
	
			var options = {
			  title: '',
			  is3D: true,
			// pieHole: 0.3,
			};
	
			var chart = new google.visualization.PieChart(document.getElementById('<?=$id?>'));
			chart.draw(data, options);
		  }
		</script>
	<?php
	}
	public function customerCountryChart($id){
	$sql = "SELECT cus.*,cou.country,count(cus.id) typecount from lot_customer cus,lot_address a, lot_country cou where a.id=cus.address_id and a.country_id=cou.id
GROUP BY cou.id";
	$connection = \Yii::$app->db;
	$command=$connection->createCommand($sql);
	$dataReader=$command->queryAll();
$xaxis = "[['Customer Country', 'Customer Country']";
foreach($dataReader as $row_customer_country) 
{
	$xaxis.=",['".$row_customer_country['country']."', ".intval($row_customer_country['typecount'])."]";
}
$xaxis.="]";
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
 <?php	
}
}
