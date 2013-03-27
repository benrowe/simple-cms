<?php
$this->breadcrumbs=array(
	'Admin' => array('default/index'),
	'Items' => array('items/index'),
	'Add'
);?>
<h1>Add</h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>


