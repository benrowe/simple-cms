<?php 
//$this->pageTitle=Yii::app()->name; 
$title = implode(' &amp; ', array_map('ucfirst', $tags));
$this->pageTitle = $title;
?>
<h1>Tags: <?php echo $title; ?></h1>

<?php $display = 0; ?>
<?php foreach ($types as $type): ?>
	<?php $tagItems = $items->getByType($type); ?>
	<?php $display += count($tagItems); ?>
	<?php if (count($tagItems) > 0): ?>
		<h2><?php echo $type->titlePlural; ?></h2>
		<?php $this->renderPartial('_itemlist', array('items' => $items, 'pages' => $pages)); ?>
	<?php endif; ?>
<?php endforeach; ?>

<?php if ($display === 0): ?>
<div class="no-results">No items for the specified tag(s)</div>
<?php endif; ?>

