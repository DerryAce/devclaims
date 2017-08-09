<?php



use yii\helpers\Html;

use kartik\detail\DetailView;

use kartik\datecontrol\DateControl;

use livefactory\models\search\History;



/**

 * @var yii\web\View $this

 * @var common\models\User $model

 */



$this->title = $model->first_name." ".$model->last_name ;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];

$this->params['breadcrumbs'][] = $this->title;

?>

<script src="../include/jquery.js"></script>

<link rel="stylesheet" href="../include/jPages.css">

<script>

	$(document).ready(function(e) {

	$("div.holder").jPages({

      containerID : "activies",

      perPage : 7,

      delay : 20

    });

        

    });

</script>

<div class="user-view">

	<!--

    <div class="page-header">

        <h1><?= Html::encode($this->title) ?></h1>

    </div>

	-->



     <div class="wrapper wrapper-content">

            <div class="row animated fadeInRight">

                <div class="col-md-4">

                    <div class="ibox float-e-margins">

                        <div class="ibox-title">

                            <h5><?php echo Yii::t('app', 'Profile'); ?> <span class="pull-right label <?=$model->status =='10'?'label-primary':'label-danger'?>"> <?=$model->status =='10'?Yii::t('app', 'Active'):Yii::t('app', 'Inactive')?> </span></h5>

                       

							<div class="ibox-tools">

                                <!--<a href="index.php?r=user/user/update&id=<?=$model->id?>">

                                    <i class="fa fa-pencil"></i>

                                </a>-->

                                <a href="index.php?r=user/user/update&id=<?=$model->id?>" class="btn btn-xs btn-primary">

                                    <i class="fa fa-pencil"></i> <?php echo Yii::t('app', 'Update'); ?>

                                </a>

                            </div>

						 </div>

                        <div>

                            <div class="ibox-content no-padding border-left-right">

                                <a href="index.php?r=user/user/update&id=<?=$model->id?>"><?php if(file_exists('../users/'.$model->id.'.png')){?>

                                    <img src="../users/<?=$model->id?>.png" width="100%" class="upload  img-responsive">								

                                <?php }else{?>

                                    <img src="../users/nophoto.jpg" class="upload  img-responsive">

                                <?php }?></a>

                            </div>

                            <div class="ibox-content profile-content">

                                <h4><strong><?php echo $model->first_name." ".$model->last_name; ?></strong></h4>

                                <p><i class="fa fa-bookmark"></i> <?php echo $model->userRole->label; ?>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-smile-o"></i> <?php echo $model->userType->label; ?></p>

								<p><i class="fa fa-envelope"></i> <?php echo $model->email; ?></p>
                                <p><i class="fa fa-user"></i> <?php echo $model->username; ?></p>



							    <h5>

                                    <?php echo Yii::t('app', 'About me'); ?>

                                </h5>

                                <p>

                                    <?php echo $model->about; ?>

                                </p>

                                <div class="row m-t-lg">

                                    <div class="col-md-4">

                                        <span class="bar">5,3,9,6,5,9,7,3,5,2</span>

                                        <h5><strong>169</strong> <?php echo Yii::t('app', 'Posts'); ?></h5>

                                    </div>

                                    <div class="col-md-4">

                                        <span class="line">5,3,9,6,5,9,7,3,5,2</span>

                                        <h5><strong>28</strong> <?php echo Yii::t('app', 'Following'); ?></h5>

                                    </div>

                                    <div class="col-md-4">

                                        <span class="bar">5,3,2,-1,-3,-2,2,3,5,2</span>

                                        <h5><strong>240</strong> <?php echo Yii::t('app', 'Followers'); ?></h5>

                                    </div>

                                </div>

                                <div class="user-button">

                                	<div class="row">

                                    	<div class="form-group">

                                        	<div class="col-sm-12">

                                            	<a href="index.php?r=user/user/mail-compose&id=<?=$model->id?>" class="btn btn-block btn-primary"><?php echo Yii::t('app', 'Send Message'); ?></a>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6">

                                       <?php if($_GET['id'] and Yii::$app->user->identity->user_role_id =='1' and $model->user_role_id !='1'){?>

                <a href="index.php?r=user/user/update&id=<?=$model->id?>&edit=t&status=<?=$model->status !='10'?'yes':'no'?>" onClick="return confirm('Are you Sure')" class="btn btn-block <?=$model->status !='10'?'btn-primary':'btn-danger'?>"><?=$model->status !='10'?'Activate User':'Deactivate User'?></a>

                <?php } ?>

                                            <!--<button type="button" class="btn btn-primary btn-sm btn-block"><i class="fa fa-envelope"></i> Send Message</button>-->

                                        </div>

                                        <div class="col-md-6">

                                           <!-- <button type="button" class="btn btn-default btn-sm btn-block"><i class="fa fa-coffee"></i> Buy a coffee</button>-->

                                        </div>

                                    </div>

                                </div>

                            </div>

                    </div>

                </div>

                    </div>

                <div class="col-md-8">

                    <div class="ibox float-e-margins">

                        <div class="ibox-title">

                            <h5><?php echo Yii::t('app', 'Activites'); ?></h5>

                            <div class="ibox-tools">

                                <a class="collapse-link">

                                    <i class="fa fa-chevron-up"></i>

                                </a>



								<!--

                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">

                                    <i class="fa fa-wrench"></i>

                                </a>

                                <ul class="dropdown-menu dropdown-user">

                                    <li><a href="#">Config option 1</a>

                                    </li>

                                    <li><a href="#">Config option 2</a>

                                    </li>

                                </ul>

								-->

                                <a class="close-link">

                                    <i class="fa fa-times"></i>

                                </a>

                            </div>

                        </div>

                        <div class="ibox-content">



                            <div>

                                <div class="feed-activity-list" id="activies">

                                	<?php

										foreach(History::getUserActivities($model->id) as $row){

									?>	

									 <div class="feed-element">

                                        <a href="#" class="pull-left">

                                       <?php if(file_exists('../users/'.$model->id.'.png')){?>

                                            <img src="../users/<?=$model->id?>.png" class="img-circle">								

                                        <?php }else{?>

                                            <img src="../users/nophoto.jpg" class="img-circle">

                                        <?php }?>

                                        </a>

                                        <div class="media-body ">

                                           <!-- <small class="pull-right text-navy">1m ago</small>-->

                                            <strong><?=ucwords($row['entity_type'])?></strong>. <br>

                                            <small class="text-muted"><?=date('F d,Y',$row['added_at'])?></small>

                                            <div class="well"><?=$row['notes']?></div>

                                        </div>

                                    </div>

                                    <?php } ?>

                                </div>

									<div class="alert alert-success" role="alert">

                                    	<div class="holder"></div>

									</div>



                            </div>



                        </div>

                    </div>



                </div>

            </div>

        </div>

</div>

