<?php

//Yii::import('bootstrap.widgets.BootButtonGroup');

class TypeButtonGroup extends CWidget // extends BootButtonGroup
{
	public $url;
	public $types = array();
	public $key = 'type';
	public $selected = array();
	public $htmlOptions = array();

	public function init()
	{
		echo CHtml::openTag('div', $this->htmlOptions);
		foreach($this->types as $type) {
			$tmp = $this->selected;
			$class = array();
			if(in_array($type, $this->selected)) {
				unset($tmp[array_search($type, $this->selected)]);
				$class[] = 'selected';
			} else {
				$tmp[] = $type;
			}
			echo CHtml::link(ucwords($type), array_merge($this->url, array($this->key => $tmp)), array('class' => implode(' ', $class)));
			//$this->buttons[] = array('label' => ucwords($type), 'url' => $this->url);
		}
		echo CHtml::closeTag('div');
	}
}