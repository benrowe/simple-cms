<?php 
$this->pageTitle=Yii::app()->name; 
$this->breadcrumbs = array();
?>
<h1>Home</h1>

<div class="item-list-container item-home">
	<?php $this->renderPartial('_itemlist', array('items' => $items)); ?>
</div>
