<?php



use yii\helpers\Html;



/**

 * @var yii\web\View $this

 * @var common\models\Customer $model

 */



$this->title = Yii::t('app', 'Add Clients', [

    'modelClass' => 'Customer',

]);

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Customers'), 'url' => ['index']];

$this->params['breadcrumbs'][] = $this->title;

?>

<script src="../include/jquery.js"></script>

<script>

function Add_Error(obj,msg){

	 $(obj).parents('.form-group').addClass('has-error');

	 $(obj).parents('.form-group').append('<div style="color:#D16E6C; clear:both" class="error"><i class="icon-remove-sign"></i> '+msg+'</div>');

	 return true;

}

function Remove_Error(obj){

	$(obj).parents('.form-group').removeClass('has-error');

	$(obj).parents('.form-group').children('.error').remove();

	return false;

}

$(document).ready(function(e) {

	$('#country_id').change(function(){

    $.post('<?=$baseUrl?>?r=liveobjects/address/ajax-load-states&country_id='+$(this).val(),function(result){

					$('#state_id').html(result);

					$('#city_id').html('<option value=""> --Select--</option>');

				})

	})

	$('#state_id').change(function(){

    $.post('<?=$baseUrl?>?r=liveobjects/address/ajax-load-cities&state_id='+$(this).val(),function(result){

					$('#city_id').html(result);

				})

	})

	$('.customer_submit').click(function(event){

		var error='';

		$('[data-validation="required"]').each(function(index, element) {

			//alert($(this).attr('id'));

			Remove_Error($(this));

			if($(this).val() == ''){

				error+=Add_Error($(this),'<?=Yii::t ('app','This Field is Required!')?>');

			}else{

					Remove_Error($(this));							

			}

			if(error !=''){

				event.preventDefault();

			}else{

				return true;

			}

		});

	});

});

</script>



                <div class="ibox float-e-margins">

                    <div class="ibox-title">

                        <h5><?= Html::encode($this->title) ?> <small class="m-l-sm"><?php echo Yii::t ( 'app', 'Enter Clients Contact & Location Details' ); ?></small></h5>

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

										 <div class="customer-create">

							<?= $this->render('_form', [

								'model' => $model,

							]) ?>

						

						</div>

                    </div>

                </div>









<!--

<div class="panel panel-primary">

	<div class="panel-heading">

    	<h3 class="panel-title"><?= Html::encode($this->title) ?>

        	<div class="pull-right">

                <a class="close" href="index.php?r=/customer/customer/index" >

                	<span class="glyphicon glyphicon-remove"></span>

                </a>

            </div>

        </h3>

    </div>

    <div class="panel-body">

        <div class="customer-create">

            <?= $this->render('_form', [

                'model' => $model,

            ]) ?>

        

        </div>

    </div>

</div>

-->