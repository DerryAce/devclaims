<?php 

$this->title =Yii::t ( 'app', 'Lead All Reports');

?>

<script src="../include/jsapi.js"></script>

<div class="col-sm-12">

	<div class="row">

    	<div class="col-sm-6">

            	<div class="panel panel-info">

                	<div class="panel-heading">

                    	<h3 class="panel-title"><?php echo Yii::t ( 'app', 'Lead Status')?></h3>

                    </div>

                    <div class="panel-body">

                    	 <div id="leadStatus"></div>

                    </div>

            </div>

        </div>

        <div class="col-sm-6">

            <div class="panel panel-info">

                <div class="panel-heading">

                    <h3 class="panel-title"><?php echo Yii::t ( 'app', 'Lead Assignment')?></h3>

                </div>

                <div class="panel-body">

                      <div id="leadAssignment"></div>

                </div>

            </div>

        </div>

    </div>

</div>



<?php  

use livefactory\models\LeadReports;

LeadReports::myLeadStatusChart('leadStatus');

$leadObj = new LeadReports();

$leadObj->getLeadAssignmentChart('leadAssignment');

?>