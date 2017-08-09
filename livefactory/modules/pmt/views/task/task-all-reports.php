<?php 

$this->title =Yii::t ( 'app','Project All Reports');

error_reporting(0);

?>

<script src="../include/jsapi.js"></script>

<div class="col-sm-12">

	<div class="row">

    	<div class="col-sm-6">

            	<div class="panel panel-info">

                	<div class="panel-heading">

                    	<h3 class="panel-title"><?=Yii::t ( 'app','Task Status')?></h3>

                    </div>

                    <div class="panel-body">

                    	 <div id="taskStatus"></div>

                    </div>

            </div>

        </div>

        <div class="col-sm-6">

            <div class="panel panel-info">

                <div class="panel-heading">

                    <h3 class="panel-title"><?=Yii::t ( 'app','Task Assignment')?></h3>

                </div>

                <div class="panel-body">

                      <div id="taskAssignment"></div>

                </div>

            </div>

        </div>

    </div>

</div>
<div class="col-sm-12">

	<div class="row">

    	<div class="col-sm-6">

            	<div class="panel panel-info">

                	<div class="panel-heading">

                    	<h3 class="panel-title"><?=Yii::t ( 'app','Defect Status')?></h3>

                    </div>

                    <div class="panel-body">

                    	 <div id="defectStatus"></div>

                    </div>

            </div>

        </div>

        <div class="col-sm-6">

            <div class="panel panel-info">

                <div class="panel-heading">

                    <h3 class="panel-title"><?=Yii::t ( 'app','Defect Assignment')?></h3>

                </div>

                <div class="panel-body">

                      <div id="defectAssignment"></div>

                </div>

            </div>

        </div>

    </div>

</div>


<?php  

use livefactory\models\TaskReports;

TaskReports::myTaskStatusChart('taskStatus');

$taskObj = new TaskReports();

$taskObj->getTaskAssignmentChart('taskAssignment');

use livefactory\models\DefectReports;

DefectReports::myDefectStatusChart('defectStatus');

$defectObj = new DefectReports();

$defectObj->getDefectAssignmentChart('defectAssignment');
?>