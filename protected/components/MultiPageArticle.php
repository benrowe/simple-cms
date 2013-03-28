<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MultiPageArticle
 *
 * @package CMS_Widget
 * @author ben
 * @property array $pages
 * @property int $page current page to view
 */
class MultiPageArticle extends CWidget
{
	public $_page;
	public $_pages;
	
	public $url;
	
	public function run()
	{
		Yii::app()->clientScript->registerScriptFile('https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js', CClientScript::POS_END);
		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/common.js', CClientScript::POS_END);
		Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/articles.js', CClientScript::POS_END);
		
		$currentPage = $this->page;
		$page = $this->pages[$currentPage-1];
		$this->render('page', array(
			'page' => $page,
			'index' => $currentPage,
			'total' => count($this->pages) 
		));
		
		if (count($this->_pages) > 1) {
			$this->render('pagenav', array(
				'url' => $this->url,
				'index' => $currentPage,
				'pages' => $this->pages
			));
		}
	}
	
	public function setPages($pages)
	{
		$this->_pages = $pages;
	}
	
	public function getPages()
	{
		return $this->_pages;
	}
	
	public function setPage($page)
	{
		$this->_page = $page;
	}
	
	/**
	 * The page index to view (starting from 1)
	 * 
	 * @return int
	 */
	public function getPage()
	{
		if (!$this->_page) {
			// get the page
			$request = Yii::app()->request;
			$page = (int)$request->getParam('page', 1);
			if ($page < 1) {
				$page = 1;
			} else if ($page > count($this->pages)) {
				$page = count($this->pages);
			}
			$this->_page = $page;
		}
		return $this->_page;
	}
}