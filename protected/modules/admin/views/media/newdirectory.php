<?php

$this->pageTitle = 'Media Manager';

$this->breadcrumbs=$this->_buildBreadcrumbs($directory, 'Create New Directory');

$this->widget('widgets.PageHeader', array(
	'title'         => 'Create New Directory',
	//'description' => 'description',
	//'buttons'     => array()
));

$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
	'id'                   => 'id-form',
	'type'                 => 'horizontal',
	'enableAjaxValidation' => true,
	'clientOptions'        => array('validateOnSubmit' => true),
));

echo '<p class="help-block">Fields with <span class="required">*</span> are required.</p>';
echo $form->errorSummary($model);

// start group: label
$this->beginWidget('widgets.FormGroup', array(
	'label' => 'label'
));

echo $form->textFieldRow($model, 'path', array('disabled' => true));
echo $form->textFieldRow($model, 'name', array());

$this->endWidget();
// end group: label

$this->widget('widgets.FormActionBar', array(
	'model' => $model,
	'cancelUrl' => array('index', 'path' => $directory->pathCoded)
));

$this->endWidget();