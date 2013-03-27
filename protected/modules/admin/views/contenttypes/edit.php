<?php

$this->pageTitle = 'Edit '.$model->titles->plural;
$this->breadcrumbs = array(
	'Admin' => array('default/index'),
	'Content Types' => array('contenttypes/index'),
	$model->titles->plural
);

?>

<h1>Edit <?php echo CHtml::encode($model->titles->plural); ?></h1>

<?php
$this->renderPartial('_form', array('model' => $model));