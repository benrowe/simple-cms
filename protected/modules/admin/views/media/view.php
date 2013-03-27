<?php
$this->breadcrumbs=$this->_buildBreadcrumbs($file);

?>

<h1><?php echo $file; ?></h1>

<?php

$this->widget('bootstrap.widgets.BootButtonGroup', array(
	'buttons' => array(
		array('label' => 'Delete', 'url' => array('media/deletefile', 'path' => $file->parent->pathCoded, 'file' => $file->filename), 'icon' => 'trash'),
		array('label' => 'Rename', 'url' => array('media/move', 'path' => $file->parent->pathCoded, 'file' => $file->filename, 'action' => 'rename'), 'icon' => 'edit'),
		array('label' => 'Move', 'url' => array('media/move', 'path' => $file->parent->pathCoded, 'file' => $file->filename), 'icon' => 'move'),
		array('label' => 'Copy', 'url' => array('media/copy', 'path' => $file->parent->pathCoded, 'file' => $file->filename), 'icon' => 'tags'),
	)
));

$this->renderPartial('_view_'.$file->mediaType, array(
	'file' => $file,
));

echo '<input value="'.$file->getUrl(true).'" class="input-xxlarge" />';