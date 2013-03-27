<?php
$form=$this->beginWidget('bootstrap.widgets.BootActiveForm', array(
	'id'=>'profile-form',
	'type' => 'horizontal',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); 

?>

	<fieldset>
		<legend>Identity</legend>
		<?php echo $form->textFieldRow($model, 'email'); ?>
		<?php echo $form->passwordFieldRow($model, 'password'); ?>
		<?php echo $form->passwordFieldRow($model, 'passwordConfirm'); ?>
	</fieldset>
	
	<fieldset>
		<legend>Details</legend>
		<?php echo $form->textFieldRow($model, 'firstname'); ?>
		<?php echo $form->textFieldRow($model, 'lastname'); ?>
		<?php echo $form->textFieldRow($model, 'display'); ?>
		<?php echo $form->textAreaRow($model, 'bio', array('class' => 'span10', 'hint' => '<a href="http://daringfireball.net/projects/markdown/">Markdown</a> supported')); ?>
	</fieldset>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'buttonType'=>'submit', 
			'type'=>'primary', 
			'icon'=>'pencil white', 
			'label'=>'Save',
			'loadingText'=>'saving...',
		)); ?>
	    <?php $this->widget('bootstrap.widgets.BootButton', array(
			'label'=>'Cancel',
			'url' => array('users/index')
		)); 
		
		?>
	</div>

<?php $this->endWidget(); ?>
