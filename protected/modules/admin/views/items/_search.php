<?php

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/admin-search.js', CClientScript::POS_END);

$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
	'id' => 'search-form',
	'method' => 'get',
	//'type'=>'search',
	'action' => array('items/index'),
	'enableClientValidation' => false,
	'htmlOptions' => array('class' => 'well well-large'),
		));


echo '<div class="item-types">'.$form->radioButtonListRow($model, 'publishStatus', array(
	'true' => 'Published (' . $count['published'] . ')',
	'false' => 'Un-published (' . $count['unpublished'] . ')',
	'' => 'All (' . $count['all'] . ')',
)).'</div>';

//echo $form->checkBoxListRow($model, 'type', CHtml::listData($types, 'id', 'titlePlural'), array('prompt' => 'Item Types'));
echo $form->textFieldRow($model, 'query');
?>

<div><?php
$this->widget('bootstrap.widgets.BootButton', array(
	'buttonType' => BootButton::BUTTON_SUBMIT,
	'label' => 'Search',
	'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
	//'size'=>'large', // '', 'large', 'small' or 'mini'
	'icon' => 'search white'
));
echo ' ';
$this->widget('bootstrap.widgets.BootButton', array(
	'label' => 'Reset',
	'url' => array('items/index'),
));
?></div>

	<?php $this->endWidget(); ?>
