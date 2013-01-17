<?php
/* @var $item WebItemPortfolio */

$this->breadcrumbs = array(
	ucfirst($item->type) => array('site/type', 'type' => $item->type),
	$item->title
);

?>
<div class="item-single item-portfolio">
	<?php $this->renderPartial('_itemheader', array('item' => $item)); ?>

	<?php $this->beginWidget('zii.widgets.CPortlet', array('title' => 'Details')); ?>
	<dl class="meta-info">
		<dt>Company</dt>
		<dd>
			<?php $this->widget('application.components.Link', array(
				'link' => $item->company['link']
			)); ?>
		</dd>
		<dt>Project Date</dt>
		<dd><?php echo $item->date; ?></dd>
		<dt>Links</dt>
		<dd>
		<?php foreach ($item->urls as $url): ?>
			<dt><?php echo $url['label']; ?></dt>
			<dd><?php $this->widget('application.components.Link', array(
				'link' => $url
			)); ?>
		<?php endforeach; ?>
		</dd>
	</dl>

	<?php $this->endWidget(); ?>

	<div class="item-body item-body-<?php echo $item->type; ?>">
		<?php $this->widget('Content', array('item' => $item, 'content' => 'body', 'markdown' => true)); ?>
	</div>



	<?php $this->widget('application.components.Gallery', array(
		'images' => $item->data['images']
	)); ?>

	<?php echo $this->renderPartial('_taglist', array('tags' => $item->tags)); ?>
</div>
