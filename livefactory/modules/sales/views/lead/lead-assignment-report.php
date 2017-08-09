<?php 

$this->title =Yii::t ( 'app', 'Lead Assignment Report');

?>

<script src="../include/jsapi.js"></script>

<!--<div class="panel panel-primary">

	<div class="panel-heading">

    	<h3 class="panel-title">Lead Status</h3>

    </div>

    <div class="panel-body">

    	<div id="leadStatus" style="height:350px"></div>

    </div>

</div>-->

<div class="panel panel-info">

	<div class="panel-heading">

    	<h3 class="panel-title"><?php echo Yii::t ( 'app', 'Lead Assingment')?> </h3>

    </div>

    <div class="panel-body">

    	<div id="leadAssignment" style="height:350px"></div>

    </div>

</div>



<?php  

use livefactory\models\LeadReports;

//LeadReports::myLeadStatusChart('leadStatus');

$leadObj = new LeadReports();

$leadObj->getLeadAssignmentChart('leadAssignment');

?>