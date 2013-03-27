<?php
$this->breadcrumbs=$this->_buildBreadcrumbs($directory, 'Delete Directory');

$link = CHtml::link($directory->name, array('index', 'path' => $directory->pathCoded));

?>
<h1>Delete <?php echo $link; ?>?</h1>

<div class="row">
	<form action="" class="well span6 offset3">
		<input type="hidden" name="r" value="admin/media/deletedir" />
		<input type="hidden" name="path" value="<?php echo $directory->pathCoded; ?>" />
		<input type="hidden" name="confirm" value="true" />
		<p>Are you sure you want to delete the directory: <?php echo $link; ?></p>

		<?php if($directory->relatedItems->count > 0): ?>
			<h2><?php echo $link; ?> is being used in the following items!</h2>

			<?php foreach($directory->relatedItems as $item): ?>
				<div><?php echo CHtml::link($item->title, array('items/view', 'type' => $item->type, 'id' => $item->id)); ?></div>
			<?php endforeach; ?>
			<label for=""><input type="checkbox" name="update" value="true" checked> Update item references</label>
		<?php endif; ?>

		<div class="form-actions">
		  	<button type="submit" class="btn btn-primary">Delete Directory</button>
		  	<?php $this->widget('bootstrap.widgets.BootButton', array(
		  		'label' => 'Cancel',
		  		'icon' => 'remove',
		  		'url' => Yii::app()->request->urlReferrer
		  	)); ?>
		</div>
	</form>
</div>