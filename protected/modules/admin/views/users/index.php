<?php
$this->breadcrumbs=array(
	'Admin' => array('default/index'),
	'Users'
);?>
<h1>Users</h1>

<?php $this->widget('bootstrap.widgets.BootButton', array(
    'label'=>'Add User',
    'type'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    //'size'=>'large', // '', 'large', 'small' or 'mini'
	'icon' => 'plus white',
	'url' => array('users/create')
)); ?>

<?php 
$d = new CArrayDataProvider($users->toArray());

$this->widget('bootstrap.widgets.BootListView', array(
	'dataProvider' => $d,
	'itemView' => '_item'
)); ?>

