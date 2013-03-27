<?php

/**
 * Main layout for admin area
 */

/* @var $cs CClientScript */
$cs = Yii::app()->clientScript;
$cs->coreScriptPosition = CClientScript::POS_END;
$cs->registerCoreScript('jquery');

$cs->registerScriptFile(Yii::app()->baseUrl.'/js/global.js', CClientScript::POS_END);
$cs->registerScriptFile(Yii::app()->baseUrl.'/js/common-admin.js', CClientScript::POS_END);
$cs->registerCssFile(Yii::app()->baseUrl.'/css/admin.css');

?>

<!DOCTYPE HTML>

<html lang="en-US">
<head>
	<meta charset="UTF-8">


	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<!--<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
		<div id="sub-logo">Programmer</div>
	</div><!-- header -->

	<?php $this->widget('bootstrap.widgets.BootNavbar', array(
		 'fixed' => false,
		//'fluid' => true,
		'brand' => false,
		//'brand' => 'Project name',
		//'brandUrl' => '#',
		//'collapse' => true, // requires bootstrap-responsive.css
		'items' => array(
			array(
				'class' => 'bootstrap.widgets.BootMenu',
				'items' => array(
					array('label' => 'Home', 'url' => array('default/index'), 'icon' => 'home white'),
					array(
						'label' => 'Items',
						'url'   => array('items/index'),
						'icon'  => 'file white',
						'items' => array(
							array('label' => 'List Items', 'url' => array('items/index'), 'icon' => 'file'),
							array('label' => 'Add Item', 'url' => array('items/add'), 'icon' => 'plus'),
						),
					),
					array('label' => 'Media', 'url' => array('media/index'), 'icon' => 'camera white'),
					array('label' => 'Users', 'url' => array('users/index'), 'icon' => 'user white'),
					array('label' => 'Content Types', 'url' => array('contenttypes/index'), 'icon' => 'th-large white'),
					array('label' => 'Visit Site', 'url' => array('/site/index'), 'icon' => 'share-alt white'),

				),
			),
			CHtml::form(array('search/index'), 'get', array('class' => 'navbar-search pull-left')).'<input type="text" class="search-query span2" name="query" placeholder="Search"></form>',
			array(
				'class'       => 'bootstrap.widgets.BootMenu',
				'htmlOptions' => array('class' => 'pull-right'),
				'items'       => array(
					array('label' => 'Your Profile', 'url' => array('profile/index'), 'icon' => 'user white'),
					//'---',
					array('items' => array( //'url' => '#',
							array('label' => 'Logout', 'url'=>array('default/logout'), 'icon' => 'off', 'linkOptions' => array('class' => 'sd', 'confirm' => 'Are you sure you want to logout?'), 'visible' => !Yii::app()->user->isGuest),
							array('label' => 'Configuration', 'url' => array('config/index'), 'icon' => 'wrench'),
							array('label' => 'Clear Cache', 'url' => array('default/cache'), 'icon' => 'ban-circle'),
					)),
				),
			),
		),
	)); ?>

	<!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.BootBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
			'homeLink' => false,
			//'separator' => ' &mdash; ',
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo $content; ?>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by Ben Rowe<br/>
		All Rights Reserved.<br/>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>