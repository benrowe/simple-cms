<div>
<?php
echo $data->title;
echo '<span class="pull-right">';
echo CHtml::link('<i class="icon-pencil"></i>', array('items/edit', 'type' => $data->type, 'id' => $data->id));
echo ' ';
if ($data->published) {
	echo CHtml::link('<i class="icon-share-alt"></i>', $data->permaUrl);
}
echo '</span>';
?>
</div>