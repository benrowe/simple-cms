<?php
$this->breadcrumbs=array(
	'Admin' => array('default/index'),
	'Users' => array('users/index'),
	$model->display
);?>
<h1>Edit <?php echo CHtml::encode($model->display); ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>

