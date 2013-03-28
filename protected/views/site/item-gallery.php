<?php 
/* @var $item WebItemGallery */

$this->breadcrumbs = array(
	ucfirst($item->type) => array('site/type', 'type' => $item->type),
	$item->title
);
?>
<div class="item-single item-gallery">
	<?php $this->renderPartial('_itemheader', array('item' => $item)); ?>
	<div class="item-body item-body-<?php echo $item->type; ?>">
		<?php $this->widget('Content', array('item' => $item, 'content' => 'body', 'markdown' => true)); ?>
	</div>
	<?php $this->widget('application.components.Gallery', array(
		'images' => $item->images
	)); ?>
	<?php echo $this->renderPartial('_taglist', array('tags' => $item->tags)); ?>
</div>
