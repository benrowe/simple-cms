<?php

/**
 * Holds the application config
 *
 * @author ben
 * @package CMS
 *
 * @property int $recordsPerPage
 * @property string $tagSplit
 * @property string $tagLimit
 * @property string $siteUrl
 * @property string $siteName
 * @property string $adminEmail
 * @property boolean $rssEnabled
 * @property string $rssDescription
 * @property string $gaTrackingNumber
 * @property string $gaEnabled
 * @property  array $mediaExtensions
 */
class Config extends CModel
{

	private static $_instance;
	private $_recordsPerPage;
	private $_tagSplit;
	private $_tagLimit;
	private $_siteUrl;
	private $_siteName;
	private $_adminEmail;
	private $_rssEnabled = true;
	private $_rssDescription;
	private $_gaTrackingNumber;
	private $_gaEnabled = false;
	private $_mediaExtensions = array();

	/**
	 * The list of attribute names that are available for configuration
	 * @return array
	 */
	public function attributeNames()
	{
		return array(
			'recordsPerPage',
			'tagSplit',
			'tagLimit',
			'siteUrl',
			'siteName',
			'adminEmail',
			'rssEnabled',
			'rssDescription',
			'gaTrackingNumber',
			'gaEnabled',
			'mediaExtensions',
		);
	}

	public function attributeLabels()
	{
		return array(
			'recordsPerPage'   => 'Pagination Limit',
			'tagSplit'         => 'Tag Split Regular Expression',
			'tagLimit'         => 'Tag Limit',
			'siteUrl'          => 'Site URL',
			'siteName'         => 'Site Name',
			'adminEmail'       => 'Admin E-mail',
			'rssEnabled'       => 'RSS Enabled',
			'rssDescription'   => 'RSS Description',
			'gaTrackingNumber' => 'Google Analytics Tracking Number',
			'gaEnabled'        => 'Google Analytics Enabled',
			'mediaExtensions'  => 'Media Extensions',
		);
	}

	/**
	 * Retrieve an instance of the Config class
	 *
	 * @return Config
	 * @throws CException
	 */
	public static function instance()
	{
		if (!self::$_instance) {
			$c = new self;
			// get the config file
			$configFile = YiiBase::getPathOfAlias('application.data.config') . '.json';
			if (!is_readable($configFile)) {
				throw new CException('Unable to load config');
			}
			if (($contents = file_get_contents($configFile)) !== false) {
				if (($json = CJSON::decode($contents)) !== null) {
					foreach ($json as $key => $value) {
						$c->$key = $value;
					}
				} else {
					throw new CException('unable to decode config');
				}
			} else {
				throw new CException('unable to load config');
			}
			self::$_instance = $c;
		}
		return self::$_instance;
	}

	/**
	 * The validation rules that apply to the configuration elements
	 *
	 * @return [type] [description]
	 */
	public function rules()
	{
		return array(
			array('siteName, siteUrl, adminEmail, recordsPerPage, tagSplit, rssDescription, gaTrackingNumber, mediaExtensions', 'required'),
			array('tagLimit', 'numerical', 'allowEmpty' => true, 'min' => 1, 'integerOnly' => true),
			array('rssEnabled, gaEnabled', 'boolean')
		);
	}

	public static function saveToFile($config)
	{
		$configFile = YiiBase::getPathOfAlias('application.data.config') . '.json';
		$str = CJSON::encode($config->getAttributes());
		return file_put_contents($configFile, $str) !== false;
	}

	public function save()
	{
		return self::saveToFile($this);
	}

	public function getAdminEmail()
	{
		return $this->_adminEmail;
	}

	public function setAdminEmail($adminEmail)
	{
		$this->_adminEmail = $adminEmail;
	}

	public function getRssEnabled()
	{
		return $this->_rssEnabled;
	}

	public function setRssEnabled($rssEnabled)
	{
		$this->_rssEnabled = $rssEnabled;
	}

	public function getSiteName()
	{
		return $this->_siteName;
	}

	public function setSiteName($siteName)
	{
		$this->_siteName = $siteName;
	}

	public function getRecordsPerPage()
	{
		return $this->_recordsPerPage;
	}

	public function setRecordsPerPage($recordsPerPage)
	{
		$this->_recordsPerPage = $recordsPerPage;
	}

	public function getTagSplit()
	{
		return $this->_tagSplit;
	}

	public function setTagSplit($tagSplit)
	{
		$this->_tagSplit = $tagSplit;
	}

	public function getTagLimit()
	{
		return $this->_tagLimit;
	}

	public function setTagLimit($tagLimit)
	{
		$this->_tagLimit = $tagLimit;
	}

	public function getSiteUrl()
	{
		return $this->_siteUrl;
	}

	public function setSiteUrl($siteUrl)
	{
		$this->_siteUrl = $siteUrl;
	}

	public function getRssDescription()
	{
		return $this->_rssDescription;
	}

	public function setRssDescription($rssDescription)
	{
		$this->_rssDescription = $rssDescription;
	}

	public function getGaTrackingNumber()
	{
		return $this->_gaTrackingNumber;
	}

	public function setGaTrackingNumber($gaTrackingNumber)
	{
		$this->_gaTrackingNumber = $gaTrackingNumber;
	}

	public function getGaEnabled()
	{
		return $this->_gaEnabled;
	}

	public function setGaEnabled($gaEnabled)
	{
		$this->_gaEnabled = $gaEnabled;
	}

	public function getMediaExtensions()
	{
		return $this->_mediaExtensions;
	}

	public function setMediaExtensions($mediaExtensions)
	{
		$this->_mediaExtensions = $mediaExtensions;
	}

}