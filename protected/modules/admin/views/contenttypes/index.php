<?php

$this->pageTitle = 'Content Types';

$this->breadcrumbs=array(
	'Admin' => array('default/index'),
	'Content Types'
);?>
<h1>Content Types</h1>

<?php /*$this->widget('bootstrap.widgets.BootButton', array(
    'label'=>'Add Content Type',
    'type'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    //'size'=>'large', // '', 'large', 'small' or 'mini'
	'icon' => 'plus white',
	'url' => array('contenttypes/create'),
	'active' => false
));*/ ?>

<?php 
$d = new CArrayDataProvider($types->toArray());

$this->widget('bootstrap.widgets.BootListView', array(
	'dataProvider' => $d,
	'itemView' => '_item'
)); ?>

