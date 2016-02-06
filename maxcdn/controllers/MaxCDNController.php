<?php
namespace Craft;

class MaxCDNController extends BaseController
{
	protected $settings;

	public function __construct()
	{
		$this->settings = craft()->plugins->getPlugin('maxcdn')->getSettings();
	}

	/**
	 * Generates the index page HTML and passes the relevant variables.
	 *
	 * @method actionIndex
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		return $this->renderTemplate('maxcdn/index', [
			'zones' => craft()->maxCDN->getZones()
		]);
	}
}