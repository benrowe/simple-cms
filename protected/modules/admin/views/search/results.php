<?php
$this->breadcrumbs=array(
	'Admin' => array('default/index'),
	'Search' => array('search/index'),
	'Results for "'.$query.'"'
);

?>

<h1>Search Results for "<?php echo CHtml::encode($query); ?>"</h1>

<?php

$this->renderPartial('_form', array('model' => $model));

$this->widget('bootstrap.widgets.BootListView', array(
	'itemView' => '_item',
	'dataProvider' => $dataProvider
));