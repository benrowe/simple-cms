<?php
$this->breadcrumbs=array(
	'Admin' => array('default/index'),
	'Users' => array('users/index'),
	'Add'
);?>
<h1>Add User</h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>

