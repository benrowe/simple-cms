<?php
Yii::app()->clientScript->registerScript('createurl', 'var createUrl = "'.$this->createUrl('default/makeurl').'";', CClientScript::POS_BEGIN);

foreach (array('markdown/Markdown.Converter.js', 'markdown/Markdown.Sanitizer.js', 'markdown/Markdown.Editor.js','admin-item-form.js') as $script) {
	Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/'.$script, CClientScript::POS_END);
}

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/admin-item-form.js', CClientScript::POS_END);

$this->widget('ext.jtagit.JTagit', array(

));

?>
<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm', array(
	'id'=>'item-form',
	'type' => 'horizontal',
	'enableAjaxValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
));

echo $form->hiddenField($model, 'action');
echo $form->hiddenField($model, 'datePublished');
echo $form->hiddenField($model, 'published');

// details
$this->beginClip('details');

echo $form->textFieldRow($model, 'title');
echo $form->textFieldRow($model, 'id');
echo $form->dropDownListRow($model, 'type', CHtml::listData(WebManager::types(), 'id', 'titlePlural'), array('disabled' => $model->scenario == 'edit'));
echo $form->dropDownListRow($model, 'authorId', User::dropdown(), array('prompt' => Yii::t('users', 'Select the author')));
echo $form->textAreaRow($model, 'description', array('class' => 'span10', 'hint' => 'No HTML'));
echo $form->textFieldRow($model, 'tags', array('hint' => 'Separate tags with commas', 'prepend' => '<i class="icon-tags"></i>', 'class' => 'tags'));
$this->endClip();

// body
$this->beginClip('body');
echo $form->textAreaRow($model, 'body', array('class' => 'span10 wmd-input', 'id' => 'wmd-input', 'hint' => '<a href="http://daringfireball.net/projects/markdown/">Markdown</a> supported'));

$this->endClip();
// data
$this->beginClip('data');
echo $form->textAreaRow($model, 'data', array('class' => 'span10 format-json', 'hint' => 'As a JSON Object {}. <a href="#" id="load-schema">Load Default Schema</a>'));
$this->endClip();

$this->widget('bootstrap.widgets.BootTabbable', array(
	'tabs' => array(
		array('label' => 'Details', 'content' => $this->getClips()->itemAt('details'), 'active' => true),
		array('label' => 'Body', 'content' => $this->getClips()->itemAt('body')),
		array('label' => 'Data', 'content' => $this->getClips()->itemAt('data')),
	),
));

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
            'htmlOptions' => array('id' => 'submit-publish'),
			'buttonType'=>'submit',
			'type'=>'primary',
			'icon'=>'pencil white',
			'label'=>'Save & Publish',
			'loadingText'=>'saving...',
		)); ?>
		<?php $this->widget('bootstrap.widgets.BootButton', array(
			'htmlOptions' => array('id' => 'preview'),

			'icon'=>'share-alt',
			'label'=>'Preview'
		)); ?>
	    <?php $this->widget('bootstrap.widgets.BootButton', array(
			'label'=>'Cancel',
			'url' => array('items/index')
		));

		?>
	</div>

<?php $this->endWidget(); ?>
