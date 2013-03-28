<?php 
/* @var $item WebItemArticle */ 

$this->breadcrumbs = array(
	ucfirst($item->type) => array('site/type', 'type' => $item->type),
	$item->title
);
?>
<div class="item-single item-article">
	<?php $this->renderPartial('_itemheader', array('item' => $item)); ?>
	<!--<div class="item-body item-body-<?php echo $item->type; ?>">
		<?php echo $item->body; ?>
	</div>-->
	<?php if(count($item->pages) > 0): ?>
	
		<?php $this->widget('application.components.MultiPageArticle', array(
			'pages' => $item->pages,
			'url' => array('site/item', 'type' => 'article', 'slug' => $item->id) 
		)); ?>
		<?php echo $this->renderPartial('_taglist', array('tags' => $item->tags)); ?>
	<?php else: ?>
		<?php $this->widget('Content', array('item' => $item, 'content' => 'body', 'markdown' => true)); ?>
	<?php endif; ?>
	<?php echo $this->renderPartial('_taglist', array('tags' => $item->tags)); ?>
</div>