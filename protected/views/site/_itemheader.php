<?php $this->pageTitle = $item->title.' - '.Yii::app()->name; ?>

<?php if (!$item->published): ?>
<div class="unpublished-warning">THIS PAGE IS NOT PUBLISHED</div>
<?php endif; ?>
<div class="item-header item-header-<?php echo $item->type; ?>">
	<h1><?php echo $item->title; ?></h1>
	<?php if(!Yii::app()->user->isGuest) echo CHtml::link('edit', array('admin/items/edit', 'type' => $item->type, 'id' => $item->id), array('class' => 'quick-edit')); ?>
	<dl class="meta-details">
		<dt class="published">Published</dt>
		<dd class="published"><?php echo $item->getDatePublished(true)->format('jS F Y'); ?>
		<dt class="created">Created</dt>
		<dd class="created"><?php echo $item->getDateCreated(true)->format('jS F Y'); ?></dd>
	</dl>
</div>
