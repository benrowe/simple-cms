<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Generates a link based on the standard item link structure
 * {
 *	'label',
 *  'url',
 *  'deprecated' - optional
 * }
 *
 * @package CMS_Widget
 * @author ben
 * @property object $link
 */
class Link extends CWidget
{

	public $link;

	public function run()
	{
		$link = $this->link;
		$a = CHtml::link($link['label'], $link['url']);

		if (isset($link['deprecated']) && $link['deprecated'] === true) {
			$a = '<del>'.$a.'</del>';
		}
		echo $a;
	}
}