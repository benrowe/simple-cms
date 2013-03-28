<?php

$this->pageTitle = 'Upload';

$this->breadcrumbs=$this->_buildBreadcrumbs($directory, 'Upload');

$this->widget('widgets.PageHeader', array(
	'title'         => 'Upload',
	//'description' => 'description',
	//'buttons'     => array()
));

$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
	'id'                   => 'id-form',
	'type'                 => 'horizontal',
	'enableAjaxValidation' => true,
	'clientOptions'        => array('validateOnSubmit' => true),
	'htmlOptions'          => array('enctype' => 'multipart/form-data')
));

echo '<p class="help-block">Fields with <span class="required">*</span> are required.</p>';
echo $form->errorSummary($model);

// start group: label
// $this->beginWidget('widgets.FormGroup', array(
// 	'label' => 'label'
// ));

echo $form->textFieldRow($model, 'path', array());

echo '<div class="control-group">
	'.$form->labelEx($model, 'files', array('class' => 'control-label')).'
	<div class="controls">';

$this->widget('CMultiFileUpload', array(
	'model' => $model,
	'attribute' => 'files',
	'max' => 5,
	'accept' => implode(',', Config::instance()->mediaExtensions)
));

echo '</div></div>';

// $this->endWidget();
// end group: label

$this->widget('widgets.FormActionBar', array(
	'model' => $model,
	'cancelUrl' => array('index')
));

$this->endWidget();