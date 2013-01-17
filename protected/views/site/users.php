<?php 
$this->pageTitle='Users - '.Yii::app()->name; 
$this->breadcrumbs = array();

?>
<h1>Authors</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'itemView' => '_authorlist',
	'dataProvider' => new CArrayDataProvider($users->toArray())
)); ?>
<div class="item-list-container item-home">
	<?php //$this->renderPartial('_itemlist', array('items' => $users)); ?>
</div>
<?php
