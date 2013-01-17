<?php

/**
 * @package CMS_Model_Form
 */
class WebItemForm extends CFormModel
{
	public $action = '';
	public $path;
	public $id;
	public $title;
	public $type;
	public $dateCreated;
	public $published;
	public $datePublished;
	public $description;
	public $authorId;
	public $body;
	public $image;
	public $tags;
	public $data = '{}';

	public function __construct($scenario = '')
	{
		parent::__construct($scenario);
		$this->dateCreated = date(WebItem::DATE_FORMAT);
	}



	/*public function attributeNames()
	{
		return array(
			'path',
			'id',
			'title'
		);
	}*/


	public function attributeLabels()
	{
		return array(
			'id' => 'Slug',
			'type' => 'Page Type'
		);
	}

	public function rules()
	{
		$config = Config::instance();

		return array(
			array('id, title, type, description, body, authorId', 'required'),
			array('id, type', 'validatorUniqueness'),
			array('id', 'match', 'pattern' => "/^[\d\w-_\.]+$/"),
			array('type', 'in', 'range' => CHtml::listData(WebManager::types(), 'id', 'id')),
			array('tags', 'filter', 'filter' => function($value) {
				// cleanup the tags string so it represents a nice tag string :)
				$val = trim($value);
				if (empty($val)) {
					return '';
				}
				return implode(', ', array_map('strtolower', array_map('trim', explode(',', $val))));
			}),
			array('tags', 'application.components.validators.Tag', 'allowEmpty' => true, 'limit' => $config->tagLimit),
			array('action, data, datePublished, published', 'safe')
		);
	}

	public function validatorUniqueness($param)
	{
		$unique = true;
		$wim = new WebManager();
		$item = $wim->getSingleItem($this->id, $this->type);
		if ($item && $item->path != $this->path) {
			$unique = false;
		}
		if (!$unique) {
			$this->addError('id', Yii::t('webitem', 'The Slug & Page Type are already in use'));
		}
	}

	public function setTags($tags)
	{
		$this->tags = $tags;
	}

}