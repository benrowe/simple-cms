<?php
$this->breadcrumbs=array(
	'Admin' => array('default/index'),
	'Profile'
);?>
<h1>Your Profile</h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>


