<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Content
 *
 * @author ben
 */
class Content extends CWidget
{
	public $item;
	public $content;
	public $markdown = false;

	const MARKER_PREFIX = '{';
	const MARKER_SUFFIX = '}';
	const TYPE_SEPARATOR = ':';


	public function run()
	{
		$content = $this->item->{$this->content};
		if ($this->markdown) {
			$md = new CMarkdownParser();
			$content = $md->safeTransform($content);
		}

		echo $this->_replaceContentMarkers($content);

	}

	private function _replaceContentMarkers($content)
	{
		$regex = "/".preg_quote(self::MARKER_PREFIX, "/")."(\w+)".preg_quote(self::TYPE_SEPARATOR, "/")."(\w+)(?:\[?(.+?)\]?)?".preg_quote(self::MARKER_SUFFIX, "/")."/";
		if (preg_match_all($regex, $content, $_matches, PREG_SET_ORDER)) {
			foreach ($_matches as $match) {
				list($exact, $type, $id) = $match;
				$attr = array();
				if (count($match) == 4) {
					// process attributes
					$attr = $this->_parseAttributes($match[3]);

				}
				$wcontent = null;
				if (isset($this->item->data[$type][$id])) {
					$data = $this->item->data[$type][$id];
					$wcontent = $this->widget(ucfirst($type), array(
						'data' => $data,
						'htmlOptions' => $attr
					), true);

				}
				$content = str_replace($exact, $wcontent, $content);
			}

		}
		return $content;
	}

	private function _parseAttributes($string)
	{
		$attrStrings = explode(',', $string);
		$attributes = array();
		foreach($attrStrings as $strValue) {
			list($key, $val) = explode('=', $strValue, 2);
			$attributes[$key] = $val;
		}
		return $attributes;
	}

}