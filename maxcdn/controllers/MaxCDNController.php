<?php
namespace Craft;

class MaxCDNController extends BaseController
{
	protected $settings;

	public function __construct()
	{
		$this->settings = craft()->plugins->getPlugin('maxcdn')->getSettings();
	}

	public function actionIndex()
	{
		return $this->renderTemplate('maxcdn/index');
	}
}