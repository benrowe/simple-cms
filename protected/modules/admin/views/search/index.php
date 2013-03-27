<?php
$this->breadcrumbs=array(
	'Admin' => array('default/index'),
	'Search'
);

?>

<h1>Search</h1>

<?php

$this->renderPartial('_form', array('model' => $model));
