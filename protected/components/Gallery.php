<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Gallery
 *
 * @author ben
 * @property array $images
 */
class Gallery extends CWidget
{

	public $images = array();
	private $_index;

	public function run()
	{
		if ($this->images) {
			Yii::app()->clientScript->registerScriptFile('https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js', CClientScript::POS_END);
			Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/common.js', CClientScript::POS_END);
			Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/gallery.js', CClientScript::POS_END);

			echo '<div class="gallery">';
			$this->render('featuredimage', array(
				'image' => $this->images[$this->index-1]
			));
			if (count($this->images) > 1) {
				$this->render('thumbnaillist', array(
					'images' => $this->images,
					'index' => $this->index
				));
			}
			echo '</div>';
		}
	}

	public function getIndex()
	{
		if (!$this->_index) {
			$request = Yii::app()->request;
			$index = (int)$request->getParam('index', 1);
			if ($index < 1) {
				$index = 1;
			} else if ($index > count($this->images)) {
				$index = count($this->images)+1;
			}

			$this->_index = $index;
		}
		return $this->_index;
	}

	public function setIndex($index)
	{
		$this->_index = $index;
	}


}