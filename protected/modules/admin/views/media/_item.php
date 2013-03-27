<?php



if($data instanceof MediaDirectory) {
	$path = $data->pathCoded;
	//$newPath = empty($path) ? $key : $path.'.'.$key;
	echo '<div class="media-item">';
	echo '<i class="icon-th-large"></i>';
	echo CHtml::link($data->name, array('index', 'path' => $path));
	echo CHtml::link('<i class="icon-trash"></i>', array('deletedir', 'path' => $path));
	echo CHtml::link('<i class="icon-download"></i>', array('download', 'path' => $path));
	echo CHtml::link('<i class="icon-upload"></i>', array('upload', 'path' => $path));
	echo CHtml::link('copy', array('copydir', 'path' => $path));
	echo CHtml::link('move', array('movedir', 'path' => $path));
	echo CHtml::link('rename', array('renamedir', 'path' => $path));
	$this->widget('bootstrap.widgets.BootLabel', array(
		'label' => $data->count.' items',
		'type'  => 'success'
	));
	echo '</div>';
} else if ($data instanceof MediaFile) {
	$path = $data->parent->pathCoded;
	echo '<div class="media-item">';
	echo '<i class="icon-file icon-file-'.$data->mediaType.'"></i>';
	echo CHtml::link($data, array('media/view', 'path' => $path, 'file' => $data));
	echo CHtml::link('<i class="icon-trash"></i>', array('deletefile', 'path' => $path, 'file' => $data));
	echo CHtml::link('<i class="icon-download"></i>', array('download', 'path' => $path, 'file' => $data));
	echo CHtml::link('copy', array('copy', 'path' => $path, 'file' => $data));
	echo CHtml::link('move', array('move', 'path' => $path, 'file' => $data));
	echo CHtml::link('rename', array('rename', 'path' => $path, 'file' => $data));
	//var_dump($data->relatedItems);
	echo '</div>';
}