<?php

/* @var $form BootActiveForm */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
	'type' => 'horizontal'
));

echo $form->textAreaRow($model, 'schema_string');

?>

<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.BootButton', array(
            'htmlOptions' => array('id' => 'submit'),
			'buttonType'=>'submit', 
			'type'=>'primary', 
			'icon'=>'pencil white', 
			'label'=>'Save',
			'loadingText'=>'saving...',
		)); ?>
	    <?php $this->widget('bootstrap.widgets.BootButton', array(
			'label'=>'Cancel',
			'url' => array('items/index')
		)); 
		
		?>
	</div>

<?php

$this->endWidget();