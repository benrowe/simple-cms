<?php
$this->breadcrumbs=array(
	'Admin' => array('default/index'),
	'Items'
);

/* @var $this CController */

?>
<h1>Web Items</h1>

<div class="btn-toolbar"><?php $this->widget('bootstrap.widgets.BootButton', array(
	    'label'=>'Add Item',
	    'type'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
	    //'size'=>'large', // '', 'large', 'small' or 'mini'
		'icon' => 'plus white',
		'url' => array('items/add')
	)); ?>
	</div>
<?php $this->renderPartial('_search', array('model' => $search, 'types' => $types, 'count' => $count)); ?>

<?php

$tabs = array();
if(is_array($search->type)) {
    $types = $types->getByIds($search->type);
}


foreach ($types as $type) {
	$tItems = $items->getByType($type);
    $tabs[] = array(
        'label' => $type->titlePlural.' ('.$tItems->count().')',
		'itemOptions' => array('class' => 'tab-'.$type->id),
        'content' => $this->renderPartial('_items', array('items' =>$tItems, 'type' => $type), true)
    );
}

$tabs[0]['active'] = true;

$this->widget('bootstrap.widgets.BootTabbable', array(
    'tabs' => $tabs
));

Yii::app()->clientScript->registerCss('tabs', '.tab-content {overflow: visible;}');

