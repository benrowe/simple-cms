<?php

/**
 * Group inner components of a form
 */
class FormGroup extends CWidget
{
	public $label;
	public $htmlOptions = array();

	public function init()
	{
		if (empty($this->label)) {
			throw new CException('label must be provided for form group');
		}

		echo CHtml::openTag('fieldset', $this->htmlOptions).CHtml::tag('legend', array(), $this->label);
	}

	public function run()
	{
		echo '</fieldset>';
	}
}