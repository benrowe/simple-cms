<div>
<?php

if ($data instanceof WebItemBase) {
	echo CHtml::link($data->title, array('items/edit', 'type' => $data->type, 'id' => $data->id));
} else {
	echo CHtml::link($data->display, array('users/edit', 'id' => $data->id));
}

?>
</div>