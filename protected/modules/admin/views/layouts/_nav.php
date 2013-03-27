<?php

$this->widget('bootstrap.widgets.BootNavbar', array(
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
					'url' => array('items/index'),
					'icon' => 'file white',
					'items' => array(
						array('label' => 'List Items', 'url' => array('items/index'), 'icon' => 'file'),
						array('label' => 'Add Item', 'url' => array('items/add'), 'icon' => 'plus'),
					),
				),
				array('label' => 'Users', 'url' => array('users/index'), 'icon' => 'user white'),
				array('label' => 'Content Types', 'url' => array('contenttypes/index'), 'icon' => 'th-large white'),
				array('label' => 'Visit Site', 'url' => array('/site/index'), 'icon' => 'share-alt white'),
				/*array('label' => 'Dropdown', 'url' => '#', 'items' => array(
						array('label' => 'Action', 'url' => '#'),
						array('label' => 'Another action', 'url' => '#'),
						array('label' => 'Something else here', 'url' => '#'),
						'---',
						array('label' => 'NAV HEADER'),
						array('label' => 'Separated link', 'url' => '#'),
						array('label' => 'One more separated link', 'url' => '#'),
				)),*/
			),
		),
		CHtml::form(array('search/index'), 'get', array('class' => 'navbar-search pull-left')).'<input type="text" class="search-query span2" name="query" placeholder="Search"></form>',
		array(
			'class' => 'bootstrap.widgets.BootMenu',
			'htmlOptions' => array('class' => 'pull-right'),
			'items' => array(
				array('label' => 'Your Profile', 'url' => array('profile/index'), 'icon' => 'user white'),
				//'---',
				array('items' => array( //'url' => '#',
						array('label' => 'Logout', 'url'=>array('default/logout'), 'icon' => 'off', 'linkOptions' => array('class' => 'sd', 'confirm' => 'Are you sure you want to logout?'), 'visible' => !Yii::app()->user->isGuest),
						array('label' => 'Configuration', 'url' => array('config/index'), 'icon' => 'wrench'),
						array('label' => 'Clear Cache', 'url' => array('default/cache'), 'icon' => 'ban-circle'),
						/*array('label' => 'Something else here', 'url' => '#'),
						'---',
						array('label' => 'Separated link', 'url' => '#'),*/
				)),
			),
		),
	),
));