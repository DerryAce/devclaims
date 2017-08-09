<?php
use livefactory\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register ( $this );
?>
<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags()?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head()?>
</head>
<body>
    <?php $this->beginBody()?>
    <div class="wrap">
        <?php
								NavBar::begin ( [ 
										'brandLabel' => 'LiveObjects',
										'brandUrl' => Yii::$app->homeUrl,
										'options' => [ 
												'class' => 'navbar-inverse navbar-fixed-top' 
										] 
								] );
								
								if (! Yii::$app->user->isGuest)
								{
									$menuItems = [ 
											[ 
													'label' => 'Dashboard',
													'url' => [ 
															'/site/index' 
													] 
											],
											
											
											
											[ 
													'label' => 'Customers',
													'items' => $menuItems = [ 
															
															[ 
																	'label' => 'Add Customer',
																	'url' => [ 
																			'/customer/customer/create' 
																	] 
															],
															[ 
																	'label' => 'Manage Customers',
																	'url' => [ 
																			'/customer/customer/index' 
																	] 
															] 
													] 
											]
											,
											
											
											
											
											
											[ 
													'label' => 'Settings',
													'items' => $menuItems = [ 
															
															[ 
																	'label' => 'Customer Types',
																	'url' => [ 
																			'/customer/customer-type/index' 
																	] 
															],
															
															
														
															
														
															
															
															[ 
																	'label' => 'Users',
																	'url' => [ 
																			'/user/user/index' 
																	] 
															],
															[ 
																	'label' => 'User Types',
																	'url' => [ 
																			'/user/user-type/index' 
																	] 
															],
															[ 
																	'label' => 'User Roles',
																	'url' => [ 
																			'/user/user-role/index' 
																	] 
															] 
													] 
											] 
									];
								}
								if (Yii::$app->user->isGuest)
								{
									$menuItems [] = [ 
											'label' => 'Login',
											'url' => [ 
													'/site/login' 
											] 
									];
								}
								else
								{
									$menuItems [] = [ 
											'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
											'url' => [ 
													'/site/logout' 
											],
											'linkOptions' => [ 
													'data-method' => 'post' 
											] 
									];
								}
								echo Nav::widget ( [ 
										'options' => [ 
												'class' => 'navbar-nav navbar-right' 
										],
										'items' => $menuItems 
								] );
								NavBar::end ();
								?>

        <div class="container">
      <!--  <?=Breadcrumbs::widget ( [ 'links' => isset ( $this->params ['breadcrumbs'] ) ? $this->params ['breadcrumbs'] : [ ] ] )?> -->
        <?= $content?>
        </div>
	</div>

	<footer class="footer">
		<div class="container">
			<p class="pull-left">&copy; LiveObjects Technologies Pvt. Ltd. <?= date('Y') ?></p>
			<!--<p class="pull-right"><?= Yii::powered("LiveFactory") ?></p> -->
		</div>
	</footer>

    <?php $this->endBody()?>
</body>
</html>
<?php $this->endPage()?>
