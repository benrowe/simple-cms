<?php

/**
 * Form for creawting new directory
 */
class NewDirectoryForm extends CFormModel
{
	public $model;
	public $name;
	public $path;

	public static function loadFromDirectory(MediaDirectory $directory)
	{
		$form = new self;
		$form->model = $directory;
		$form->path = $directory->pathCoded;
		return $form;
	}

	public function save()
	{
		return $this->model->addSubDir($this->name);
	}

	public function rules()
	{
		return array(
			array('name', 'match', 'pattern' => '/^[a-z0-9_]+$/i', 'message' => 'May only contain A-Z, 0-9, _ characters', 'allowEmpty' => false),
			array('path', 'unsafe')
		);
	}

	public function attributeLabels()
	{
		return array(
			'name' => 'Directory Name'
		);
	}
}