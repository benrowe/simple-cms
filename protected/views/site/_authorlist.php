<?php
/* @var $data User */
?>
<div>
	<h2><?php echo CHtml::link($data->display, array('site/author', 'id' => $data->id)); ?></h2>
</div>