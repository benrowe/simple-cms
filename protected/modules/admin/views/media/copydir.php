<?php
$this->breadcrumbs=$this->_buildBreadcrumbs($directory, 'Copy');

$link = CHtml::link($directory->name, array('index', 'path' => $directory->pathCoded), array('class' => 'media-file'));

?>
<h1>Copy <?php echo $link; ?>?</h1>

<div class="row">
	<form action="" class="well span6 offset3 form-horizontal">
		<input type="hidden" name="r" value="admin/media/copydir" />
		<input type="hidden" name="path" value="<?php echo $directory->pathCoded; ?>" />
		<input type="hidden" name="confirm" value="true" />

		<div class="control-group">
			<label for="" class="control-label">New Path</label>
			<div class="controls"><input name="newPath" value="<?php echo $directory->pathCoded; ?>"></div>
		</div>


		<?php /*if($file->relatedItems->count > 0): ?>
			<h2><?php echo $link; ?> is being used in the following items!</h2>

			<?php foreach($file->relatedItems as $item): ?>
				<div><?php echo CHtml::link($item->title, array('items/view', 'type' => $item->type, 'id' => $item->id)); ?></div>
			<?php endforeach; ?>
			<label for=""><input type="checkbox" name="update" value="true" checked> Update item references</label>
		<?php endif;*/ ?>

		<div class="form-actions">
		  	<button type="submit" class="btn btn-primary">Copy Directory</button>
		  	<?php $this->widget('bootstrap.widgets.BootButton', array(
		  		'label' => 'Cancel',
		  		'icon' => 'remove',
		  		'url' => Yii::app()->request->urlReferrer
		  	)); ?>
		</div>
	</form>
</div>