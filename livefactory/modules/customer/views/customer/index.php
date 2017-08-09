<?php



use yii\helpers\Html;

use kartik\grid\GridView;

use yii\widgets\Pjax;

use livefactory\models\CustomerType;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;


/**

 *

 * @var yii\web\View $this

 * @var yii\data\ActiveDataProvider $dataProvider

 * @var common\models\search\Customer $searchModel

 */



$this->title = Yii::t ( 'app', 'Clients' );

$this->params ['breadcrumbs'] [] = $this->title;
$pageView = !empty($_GET['view'])?$_GET['view']:Yii::$app->params['DEFAULT_SEARCH_PAGE_VIEW'];

?>

<link rel="stylesheet" href="../include/jPages.css">

<div class="row">

<div class="ibox float-e-margins">

      <div class="ibox-title">

                        <h5><?= Html::encode($this->title) ?> </h5>

                        <div class="ibox-tools">

                        	<button class="btn btn-xs btn-info box_btn  <?=$pageView  =='List View'?'':'hide' ?>"><?php echo Yii::t ( 'app', 'Switch to Tiles View' ); ?></button>

                            <button class="btn btn-xs btn-info list_btn <?=$pageView  =='List View'?'hide':'' ?>"><?php echo Yii::t ( 'app', 'Switch to List View' ); ?></button>

						    <a class="collapse-link">

                                <i class="fa fa-chevron-up"></i>

                            </a>

                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">

                                <i class="fa fa-wrench"></i>

                            </a>

                            <ul class="dropdown-menu dropdown-user">

                                <li><a href="javascript:void(0)"  class="box_btn <?=$pageView  =='List View'?'':'hide' ?>"><?php echo Yii::t ( 'app', 'Switch to Tiles View' ); ?></a>

                                </li>

                                <li><a href="javascript:void(0)" class="list_btn  <?=$pageView  =='List View'?'hide':'' ?>"><?php echo Yii::t ( 'app', 'Switch to List View' ); ?></a>

                                </li>

                            </ul>

                            <a class="close-link">

                                <i class="fa fa-times"></i>

                            </a>

                        </div>

                    </div>

        <div class="ibox-content">

            <div class="customer-index">

            	<div class="box row <?=$pageView  =='List View'?'hide':'' ?>" >

                	<div class="col-sm-12">

                        <div class="row" id="customer_div">

                        <?php foreach($dataProviderBox as $row){?>

                            <div class="col-lg-4">

                                <div class="contact-box">

                                    <a href="index.php?r=customer/customer/customer-view&id=<?=$row['id']?>">

                                    <div class="col-sm-4">

                                        <div class="text-center">

                                        	<?php

											$path='../customers/'.$row['id'].'.png';

											if(file_exists($path)){?>

												<img  class="img-circle m-t-xs img-responsive"  src="../customers/<?=$row['id']?>.png">								

											<?php }else{?>

												<img   class="img-circle m-t-xs img-responsive" src="../customers/nophoto.jpg">

											<?php }

										?>

                                            <div class="m-t-xs font-bold"><?=$row['type']?></div>

                                            <div class="form-group">
	
                                                <a href="index.php?r=customer/customer/customer-view&id=<?=$row['id']?>" style="color:#fff;" class="btn btn-xs  btn-success"><span class="glyphicon glyphicon-eye-open"></span></a>
                                                <form action="index.php?r=customer/customer/delete&id=<?=$row['id']?>" method="post" name="cus<?=$row['id']?>" style="display:inline">
                                                <?php Yii::$app->request->enableCsrfValidation = true; ?>

    <input type="hidden" name="_csrf" value="<?php echo $this->renderDynamic('return Yii::$app->request->csrfToken;'); ?>">
        <button type="submit" onClick="return confirm('<?=Yii::t ('app','Are you Sure!')?>')" style="color:#fff;" class="btn btn-xs  btn-danger"><span class="glyphicon glyphicon-trash"></span></button>
    </form>

                                                

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-sm-8">

                                        <h3><strong><?=$row['customer_name']?></strong></h3>

                                        <p><i class="fa fa-map-marker"></i> <?=$row['first_name']?> <?=$row['last_name']?></p>

                                        <address>

                                            <?=!empty($row['address_1'])?$row['address_1'].",":''?> <?=$row['city']?><br>

                                            <?=!empty($row['state'])?$row['state'].",":''?> <?=$row['country']?><br>

                                            <abbr title="Phone">P:</abbr> <?=$row['phone']?>

                                        </address>

                                    </div>

                                    <div class="clearfix"></div>

                                        </a>

                                </div>

                            </div>

                            

                        <?php } ?>

                            

                        </div>

                        <div class="row">

                            <div class="holder"></div>

                        </div>

                     </div>

                 </div>

                <div class="gridlist <?=$pageView =='List View'?'':'hide' ?>">

               	 <form action="" method="post" name="frm">

            <?php Yii::$app->request->enableCsrfValidation = true; ?>

            <input type="hidden" name="_csrf" value="<?php echo $this->renderDynamic('return Yii::$app->request->csrfToken;'); ?>">

            <input type="hidden" name="multiple_del" value="true">

            <?php

                        

        Pjax::begin ();

                        echo GridView::widget ( [ 

                                'dataProvider' => $dataProvider,

                                'filterModel' => $searchModel,

                                'columns' => [ 

                                        ['class' => '\kartik\grid\CheckboxColumn'],

                                        ['class' => 'yii\grid\SerialColumn'],

                                        

                                        // 'id',

                                        [ 

                                                'attribute' => 'customer_name',

                                                'width' => '200px',

                                                'format' => 'raw',

                                                'value' => function ($model, $key, $index, $widget)

                                                {

                                                    return '<a href="?r=customer/customer/customer-view&id=' . $model->id . '">' . $model->customer_name . '</a>';

                                                } 

                                        ],

                                        [ 

                                                'attribute' => 'customer_type_id',

                                               // 'label' => 'Type',

                                                'filterType' => GridView::FILTER_SELECT2,

                                                'format' => 'raw',

                                                'width' => '100px',

                                                'filter' => ArrayHelper::map ( CustomerType::find ()->orderBy ( 'sort_order' )->asArray ()->all (), 'id', 'label' ),

                                                'filterWidgetOptions' => [ 

                                                        'options' => [ 

                                                                'placeholder' => 'All...' 

                                                        ],

                                                        'pluginOptions' => [ 

                                                                'allowClear' => true 

                                                        ] 

                                                ],

                                                'value' => function ($model, $key, $index, $widget)

                                                {

                                                    // var_dump($model->user);

                                                    // var_dump($model->customerType);

                                                    if (isset ( $model->customerType ) && ! empty ( $model->customerType->label ))

                                                        return $model->customerType->label;

                                                } 

                                        ],

                                        'first_name',

                                        'last_name',

                                        'email:email',

                                        

                                        // 'phone',

                                        'mobile',

                                        

                                        // 'fax',

                                        // 'address_id',

                                        // 'created_at',

                                        // 'updated_at',

                                        

                                        [ 

                                                'class' => 'yii\grid\ActionColumn',

                                                'template' => '{update} {delete}',

                                                'buttons' => [ 

                                                        'update' => function ($url, $model)

                                                        {

                                                            return '<a href="?r=customer/customer/customer-view&id=' . $model->id . '"><span class="glyphicon glyphicon-eye-open"></span></a>';

                                                            /*return Html::a ( '<span class="glyphicon glyphicon-eye-open"></span>', Yii::$app->urlManager->createUrl ( [ 

                                                                    'customer/customer/update',

                                                                    'id' => $model->id,

                                                                    'edit' => 't' 

                                                            ] ), [ 

                                                                    'title' => Yii::t ( 'yii', 'Edit' ) 

                                                            ] );*/

                                                        } 

                                                ]

                                                 

                                        ] 

                                ],

                                'responsive' => true,

                                

                                'hover' => true,

                                'condensed' => true,

                                'floatHeader' => false,

                                

                                'panel' => [ 

                                        'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Yii::t ( 'app', 'Clients' ).' </h3>',

                                        'type' => 'info',

                                        'before' => Html::a ( '<i class="glyphicon glyphicon-plus"></i> '.Yii::t ( 'app', 'Add' ), [ 

                                                'create' 

                                        ], [ 

                                                'class' => 'btn btn-success' 

                                        ] ).' <a href="javascript:void(0)" onClick="all_del()" class="btn btn-danger"><i class="glyphicon glyphicon-trash"></i> '.Yii::t ( 'app', 'Delete Selected' ).'</a>',

                                        'after' => Html::a ( '<i class="glyphicon glyphicon-repeat"></i> '.Yii::t ( 'app', 'Reset List' ), [ 

                                                'index' 

                                        ], [ 

                                                'class' => 'btn btn-info' 

                                        ] ),

                                        'showFooter' => false 

                                ] 

                        ] );

                        Pjax::end ();

                        ?>

        </form>

       			</div>

          </div>

		</div>

	</div>

</div>



<!--

	<div class="page-header">

		<h1><?= Html::encode($this->title) ?></h1>

	</div>

	-->



    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



  

        <?php 

/*

				       * echo Html::a(Yii::t('app', 'Create {modelClass}', [

				       * 'modelClass' => 'Customer',

				       * ]), ['create'], ['class' => 'btn btn-success'])

				       */

								?>

   



<script src="../include/jquery.js"></script>

<script>
var pageView = '<?= !empty($_GET['view'])?$_GET['view']:$app->params['DEFAULT_SEARCH_PAGE_VIEW']?>';
var view = '<?=Yii::$app->params['DEFAULT_SEARCH_PAGE_VIEW'] =='List View'?'gridlist':'box' ?>';
	function all_del(){

		var r = confirm("<?=Yii::t ('app','Are you Sure!')?>");

		if (r == true) {

			document.frm.submit()

		} else {

			

		}	

	}

        $(document).ready(function(){

			$('.box_btn').click(function(){
				document.location.href='index.php?r=customer/customer/index&view=Tile View';
				/*$('.box').show();
				$(this).addClass('hide');
				$('.list_btn').removeClass('hide');
				$('.gridlist').hide();*/

			})

			$('.list_btn').click(function(){
				document.location.href='index.php?r=customer/customer/index&view=List View';
				/*$('.gridlist').show();
				$(this).addClass('hide');
				$('.box_btn').removeClass('hide');	
				$('.box').hide();*/

			})

			

			// $('.tabbable').appendTo('#w0');

			//console.log($('a[data-toggle="tab"]:first').tab('show'))

			$('a[data-toggle="tab"]').on('shown.bs.tab', function () {

				//save the latest tab; use cookies if you like 'em better:

			//	localStorage.setItem('lastTab_leadview', $(this).attr('href'));

			});

		

			//go to the latest tab, if it exists:

			var lastTab_leadview = localStorage.getItem('lastTab_leadview');

			if ($('a[href=' + lastTab_leadview + ']').length > 0) {

				$('a[href=' + lastTab_leadview + ']').tab('show');

			}

			else

			{

				// Set the first tab if cookie do not exist

				$('a[data-toggle="tab"]:first').tab('show');

			}

            $('.contact-box').each(function() {

                animationHover(this, 'pulse');

            });

			var maxVal=0

			$('.contact-box').each(function(){

				if($(this).outerHeight()>maxVal){

					maxVal=	$(this).outerHeight();

				}

			})

			$('.contact-box').each(function(){

				$(this).css({'height':maxVal});

			})

			$("div.holder").jPages({

			  containerID : "customer_div",

			  perPage : 9,

			  delay : 20

			});

			//	setTimeout(function(){
				/*if(view=='gridlist'){
					$('.gridlist').show();
					$('.box').hide();
				}else{
					$('.gridlist').hide();
					$('.box').show();
				}*/
				

				//},1000);

        });

    </script>

