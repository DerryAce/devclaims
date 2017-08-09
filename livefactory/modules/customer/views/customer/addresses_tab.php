<?php



use yii\helpers\Html;

use kartik\grid\GridView;

use yii\widgets\Pjax;

use livefactory\models\Address;

use yii\helpers\ArrayHelper;

?>

    <div class="panel panel-primary">

    	<div class="panel panel-heading">

        	<h3 class="panel-title">

            	<i class="glyphicon glyphicon-th-list"></i> <?php echo Yii::t('app', 'Addresses'); ?>

           </h3>

        </div>

        <div class="panel-body">

        	<table class="table table-bordered">

            	<thead>

                    <tr>

                        <th><?php echo Yii::t('app', 'Address'); ?>Address</th>

                        <th><?php echo Yii::t('app', 'Zipcode'); ?></th>

                        <th><?php echo Yii::t('app', 'Country'); ?></th>

                        <th><?php echo Yii::t('app', 'County'); ?></th>

                        <th><?php echo Yii::t('app', 'City'); ?></th>

                        <th><?php echo Yii::t('app', 'Action'); ?></th>
                        

                    </tr>

                </thead>

                <tbody>

                	<?php foreach($dataProviderAddresses as $row){?>

                    	<tr>

                        	<td><?=$row['address_1']?></td>

                            <td><?=$row['zipcode']?></td>

                            <td><?=$row['country']?></td>

                            <td><?=$row['state']?></td>

                            <td><?=$row['city']?></td>

                            <td>

                            	<form name="address_edit<?=$row['address_id']?>" action="index.php?r=<?=$_GET['r']?>&id=<?=$_GET['id']?>&address_edit=<?=$row['address_id']?>" method="post" style="display:inline"><input value="bVZFZzJuWWwZIXMSQTE6QS5mHyVmCG0tHxgEKGQvOA4sBwBXYBthIw==" name="_csrf" type="hidden">

									<a href="#" onclick="document.address_edit<?=$row['address_id']?>.submit()" title="Edit" target="_parent"><span class="glyphicon glyphicon-pencil"></span></a></form>

                                  <form id="address_del<?=$row['address_id']?>" action="index.php?r=<?=$_GET['r']?>&id=<?=$_GET['id']?>&address_del=<?=$row['address_id']?>" method="post" style="display:inline"><input value="bVZFZzJuWWwZIXMSQTE6QS5mHyVmCG0tHxgEKGQvOA4sBwBXYBthIw==" name="_csrf" type="hidden">

									<a href="#" onclick="confirm_del('address_del<?=$row['address_id']?>')" title="Delete" target="_parent"><span class="glyphicon glyphicon-trash"></span></a></form>

                            </td>

                        </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

	<script>

	function confirm_del(frm){

		var r = confirm("Press a button!");

			if (r == true) {

				$('#'+frm).submit();

			} 	

	}

	</script>