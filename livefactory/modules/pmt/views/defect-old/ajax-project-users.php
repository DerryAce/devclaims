<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\Task $model
 */
?>
<option value="">--Assigned User--</option>
<?
foreach($dataReader as $user){?>
<option value="<?=$user['id']?>" <?=$user['id']==$user_id?'selected':''?>><?=$user['first_name']?> <?=$user['last_name']?></option>
<?	
}?>
