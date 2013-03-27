<?php

$this->pageTitle = 'Media Manager';

$this->breadcrumbs=$this->_buildBreadcrumbs($directory);

$this->widget('widgets.PageHeader', array(
	'title'   => $directory->name.' ('.$directory->count.')',
	'buttons' => array(
		array(
			'label' => 'New Directory',
			'icon'  => 'plus',
			'url'   => array('newdirectory', 'path' => $directory->pathCoded)
		),
		array(
			'label' => 'Upload',
			'icon' => 'upload',
			'url' => array('upload', 'path' => $directory->pathCoded)
		),
		array(
			'label'	=> 'Download',
			'icon'	=> 'download',
			'url'	=> array('download', 'path' => $directory->pathCoded)
		)
	)
));

$this->widget('widgets.media.TypeButtonGroup', array(
	'url' => array('index', 'path' => $directory->pathCoded),
	'types' => array('image', 'audio', 'video', 'other'),
	'selected' => $filters
))

?>

<style type="text/css">
	.media-item {
		padding: 10px;
		border: 1px solid #C5C5C5;
	}
	[class^="icon-file-"], [class*=" icon-file-"] {
		background-image: url(images/sprite.png);
	}

	.icon-file-image {

	}
	.icon-file-audio {
		background-position: -16px -16px;
	}

	.selected{
		background: blue;
		color: white;
		padding: 5px;
	}

</style>

<?php

$this->renderPartial('_form');

$this->widget('xupload.XUpload', array(
    'url' => Yii::app()->createUrl("admin/media/upload"),
    'model' => $model,
    'attribute' => 'file',
    'multiple' => true,
));

?>

<form method="get" action="<?php echo CHtml::normalizeUrl(''); ?>">
	<input type="hidden" name="r" value="admin/media/index">
	<div class="input-prepend input-append">
		<span class="add-on">/</span><input type="search" name="path" value="<?php echo $directory->pathCoded; ?>"><button class="btn">Change Directory</button>
	</div>

</form>

<?php

if (!$directory->isRoot()) {
	echo '<div class="media-item">';

	//array_pop($bits);
	echo CHtml::link('..', array('index', 'path' => $directory->parent->pathCoded));
	echo '</div>';
}

$this->widget('bootstrap.widgets.BootListView', array(
	'dataProvider' => new CArrayDataProvider($directory->getAll($filters), array('keyField' => 'fullPath')),
	'itemView'     => '_item',
    //'sortableAttributes'=>array(
    //    'title',
    //    'create_time'=>'Post Time',
    //),
));
