<?php
$this->pageTitle = Yii::app()->name . ' - Login';

$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
	'id' => 'login-form',
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
	'htmlOptions' => array('class' => 'well well-login span6 offset3')
		));

$this->widget('bootstrap.widgets.BootAlert');

echo $form->textFieldRow($model, 'username', array('class' => 'span6'));
echo $form->passwordFieldRow($model, 'password', array('class' => 'span6'));
echo $form->checkBoxRow($model, 'rememberMe');

$this->widget('bootstrap.widgets.BootButton', array(
	'buttonType' => 'submit',
	'type' => 'primary',
	'label' => 'Login',
	'icon' => 'user white',
	'htmlOptions' => array('class' => 'pull-right')
		//'class' => 'sdf'
));

$this->endWidget();