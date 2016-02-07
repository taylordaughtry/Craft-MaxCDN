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
			'files' => craft()->maxCDN->getPopularFiles(),
		]);
	}

	public function actionZones()
	{
		$zones = craft()->maxCDN->getZones();

		$viewData = [];

		foreach ($zones as $zone) {
			$stats = craft()->maxCDN->getZoneStats($zone->id);

			$viewData[$zone->id] = [
				'name' => $zone->name,
				'hits' => $stats->hit,
				'cacheHits' => $stats->cache_hit,
				'nonCacheHits' => $stats->noncache_hit,
				'size' => $stats->size,

			];
		}

		return $this->renderTemplate('maxcdn/zones', [
				'zones' => $viewData,
		]);
	}
}