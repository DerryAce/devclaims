<?php
use livefactory\models\search\CommonModel;
$this->title ='Search Results'; 
?>
<link rel="stylesheet" href="../include/jPages.css">
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <!--<h2>
                                2,160 results found for: <span class="text-navy">“Admin Theme”</span>
                            </h2>
                            <small>Request time  (0.23 seconds)</small>-->

                            <div class="search-form">
                                <form role="search"  method="post" action="index.php?r=site/search-results">
             <?php Yii::$app->request->enableCsrfValidation = true; ?>
              <input type="hidden" name="_csrf" value="<?php echo $this->renderDynamic('return Yii::$app->request->csrfToken;'); ?>">
                                    <div class="input-group">
                                        <input type="text" value="<?=$_REQUEST['top_search']?>" placeholder="Search for something..." name="top_search" class="form-control input-lg">
                                        <div class="input-group-btn">
                                            <button class="btn btn-lg btn-primary" type="submit">
                                                Search
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="ibox float-e-margins">
                                        <div class="ibox-title">
                                            <h5>Incident Results : <?=$taskModel!=''?count($taskModel):''?></h5>
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
                                        	<div id="tasks">
                                        	<?php
											if($taskModel !=''){
												foreach($taskModel as $task){?>
													<div class="search-result" style="border-bottom:1px dashed #e7eaec">
														<h3><a href="index.php?r=pmt/task/task-view&id=<?=$task['id']?>"><?=(strlen($task['task_name']) > 50) ? substr($task['task_name'],0,50).'...' :$task['task_name'];?></a></h3>
														<a href="index.php?r=pmt/task/task-view&id=<?=$task['id']?>" class="search-link"><?=date('F d,Y',strtotime($task['date_added']))?></a>
                                                        <?php
															$desc = str_replace('&lt;p&gt;', '', $task['task_description']);
															$desc = str_replace('&lt;/p&gt;', '', $desc);
														?>
														<p><?=(strlen($desc) > 150) ? substr($desc,0,150).'...' :$desc;?></p>
													</div>
											<?php	}
											}else{
												echo "no result";	
											}
											?>
                                            </div>
                                            <div class="holder task_holder"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="ibox float-e-margins">
                                        <div class="ibox-title">
                                            <h5>Claim Results : <?=$projectModel !=''?count($projectModel):''?></h5>
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
                                        	<div id="projects">
                                        	<?php
											if($projectModel !=''){
												foreach($projectModel as $project){?>
													<div class="search-result" style="border-bottom:1px dashed #e7eaec">
														<h3><a href="index.php?r=pmt/project/project-view&id=<?=$task['id']?>"><?=(strlen($project['project_name']) > 50) ? substr($project['project_name'],0,50).'...' :$project['project_name'];?></a></h3>
														<a href="index.php?r=pmt/project/project-view&id=<?=$project['id']?>" class="search-link"><?=date('F d,Y',strtotime($project['expected_start_date']))?></a>
                                                        <?php
															$desc = str_replace('&lt;p&gt;', '', $project['project_description']);
															$desc = str_replace('&lt;/p&gt;', '', $desc);
														?>
														<p><?=(strlen($desc) > 150) ? substr($desc,0,150).'...' :$desc;?></p>
													</div>
											<?php	}
											}else{
												echo "no result";	
											}
											?>
                                            </div>
                                            <div class="holder project_holder"></div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                </div>
        </div>
</div>

<script src="../include/jquery.js"></script>
<script>
	$(document).ready(function(e) {
	$("div.task_holder").jPages({
      containerID : "tasks",
      perPage : 7,
      delay : 20
    });
	$("div.project_holder").jPages({
      containerID : "projects",
      perPage : 7,
      delay : 20
    });
        
    });
	</script>