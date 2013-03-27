<?php
$this->breadcrumbs=array(
	'Admin' => array('default/index'),
	'Items' => array('items/index'),
	''.$model->title
);?>
<h1>Edit <?php echo CHtml::encode($model->title); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>


