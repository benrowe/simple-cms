<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Media
 *
 * @package CMS_Widget
 * @author ben
 */
class Media extends CWidget
{
	public $data;
	public $htmlOptions = array();

	public function run()
	{
		$src = Yii::app()->request->baseUrl.'/'.$this->data['file'];
		$image = CHtml::image($src, $this->data['title']);
		echo CHtml::tag('div', $this->htmlOptions, $image);

	}

}