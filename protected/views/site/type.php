<?php 
$titles = CHtml::listData($types, 'titlePlural', 'titlePlural');
$ids = CHtml::listData($types, 'id', 'id');
$title = implode(' &amp; ', $titles);
$this->pageTitle=$title.' - '.Yii::app()->name; 
$this->breadcrumbs = array($title);
?>
<h1><?php echo $title; ?></h1>
<div class="item-list-container item-<?php echo implode('-', $ids); ?>">
<?php $this->renderPartial('_itemlist', array('items' => $items, 'pages' => $pages)); ?>
</div>
