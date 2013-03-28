<?php

$this->pageTitle = 'Site Configuration';
$this->breadcrumbs = array(
	'Admin' => array('default/index'),
	'Configuration'
)

?>

<h1>Configuration</h1>

<?php

$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
	'id' => 'config-form',
	'type' => 'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
));

$this->widget('bootstrap.widgets.BootTabbable', array(
    'type'=>'tabs',
	'tabs' => array(
		array('label' => 'Site Details', 'active' => true, 'content' => 
			$form->textFieldRow($model, 'siteName').
			$form->textFieldRow($model, 'siteUrl').
			$form->textFieldRow($model, 'adminEmail').
			$form->radioButtonListInlineRow($model, 'gaEnabled', array(true => 'Enabled', false => 'Disabled')).
			$form->textFieldRow($model, 'gaTrackingNumber')
		),
		array('label' => 'Item Setup', 'content' => 
			$form->textFieldRow($model, 'recordsPerPage').
			$form->textFieldRow($model, 'tagSplit').
			$form->textFieldRow($model, 'tagLimit', array('hint' => '', 'class' => ''))
		),
		array('label' => 'RSS', 'content' => 
			$form->radioButtonListInlineRow($model, 'rssEnabled', array(true => 'Enabled', false => 'Disabled')).
			$form->textFieldRow($model, 'rssDescription')
		),
	)
)); 
?>

<div class="form-actions">
	<?php
	$this->widget('bootstrap.widgets.BootButton', array(
		'buttonType' => 'submit',
		'type' => 'primary',
		'icon' => 'pencil white',
		'label' => 'Save',
		'loadingText' => 'saving...',
	));
	echo ' ';
	$this->widget('bootstrap.widgets.BootButton', array(
		'label' => 'Cancel',
		'url' => array('config/index')
	));
	?>
</div>


<?php

$this->endWidget();
?>