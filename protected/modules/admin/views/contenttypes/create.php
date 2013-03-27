<?php

$this->pageTitle = 'Create Content Type ';
$this->breadcrumbs = array(
	'Admin' => array('default/index'),
	'Content Types' => array('contenttypes/index'),
	'Create'
);

?>

<h1>Create Content Type</h1>

<?php
$this->renderPartial('_form', array('model' => $model));