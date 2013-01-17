<?php
/* @var $item WebItemProject */

$this->breadcrumbs = array(
	ucfirst($item->type) => array('site/type', 'type' => $item->type),
	$item->title
);

?>
<div class="item-single item-project">
	<?php $this->renderPartial('_itemheader', array('item' => $item)); ?>
	<div class="item-body item-body-<?php echo $item->type; ?>">
		<?php $this->widget('Content', array('item' => $item, 'content' => 'body', 'markdown' => true)); ?>
	</div>
	<?php $this->beginWidget('zii.widgets.CPortlet', array('title' => 'Details')); ?>
	<dl class="meta-info">
		<?php if(is_array($item->sourceCode)): ?>
		<dt>Source Code</dt>
		<dd><?php $this->widget('application.components.Link', array('link' => $item->sourceCode)); ?></dd>
		<?php endif; ?>
		<dt>Category</dt>
		<dd><?php echo $item->category; ?></dd>
		<dt>Demos</dt>
		<dd>
			<dl>
			<?php foreach ($item->demos as $url): ?>
				<dt><?php echo $url->label; ?></dt>
				<dd><?php $this->widget('application.components.Link', array(
					'link' => $url
				)); ?>
			<?php endforeach; ?>
			</dl>
		</dd>
		<dt>Versions</dt>
			<ul>
				<li>
				<?php foreach ($item->versions as $version): ?>
					<?php echo $version['number']; ?>
					<?php $this->widget('application.components.Link', array('link' => $version['downloadUrl'])); ?> (<?php echo $version['size']; ?> bytes)
				<?php echo $version['releaseDate']; ?>

				</li>
				<?php endforeach; ?>
			</ul>
		<dd>

		</dd>
	</dl>
	<?php $this->endWidget(); ?>
	<h2>Requirements</h2>
	<?php echo $item->requirements; ?>

	<h2>Media</h2>
	<?php $this->widget('application.components.Gallery', array('images' => $item->media)); ?>
	<?php echo $this->renderPartial('_taglist', array('tags' => $item->tags)); ?>
</div>
