<?php

/**
 *
 */

Yii::import('zii.widgets.jui.CJuiWidget');

/**
 *
 */
class JTagit extends CJuiWidget
{
	public $className = 'tags';

	public function init()
	{
		parent::init();
		$this->_registerFiles();
	}

	private function _registerFiles()
	{
		$basePath = Yii::getPathOfAlias('ext.jtagit.assets');

		$baseUrl = Yii::app()->getAssetManager()->publish($basePath);

		$cs=Yii::app()->getClientScript();
		$cs->registerScriptFile($baseUrl.'/js/tagit.js', CClientScript::POS_READY);
		$cs->registerCssFile($baseUrl . '/css/tagit-awesome-blue.css');

		$cs->registerScript('test', 'var availableTags = [
		"ActionScript",
		"AppleScript",
		"Asp",
		"BASIC",
		"C",
		"C++",
		"Clojure",
		"COBOL",
		"ColdFusion",
		"Erlang",
		"Fortran",
		"Groovy",
		"Haskell",
		"Java",
		"JavaScript",
		"Lisp",
		"Perl",
		"PHP",
		"Python",
		"Ruby",
		"Scala",
		"Scheme"
	  ];');
		$cs->registerScript('jtagit-'.$this->className, '$(\'.'.$this->className.'\').tagit({tagSource:availableTags, select:true, sortable:true});');
	}

}