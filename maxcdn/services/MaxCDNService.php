<?php
namespace Craft;

class MaxCDNService extends BaseApplicationComponent
{
    /*
        Plugin Settings
     */
    protected $settings;

    /*
        An instance of the MaxCDN API.
     */
	protected $api;

    public function __construct()
    {
    	$this->settings =craft()->plugins->getPlugin('maxcdn')->getSettings();

    	$this->api = new \NetDNA(
	    	$this->settings->alias,
	    	$this->settings->consumerKey,
	    	$this->settings->consumerSecret
    	);
    }

    /**
     * Get a list of zones. This DOES NOT include stats, just the ID,
     * name, and other relevant metadata about the zone.
     *
     * @method getZones
     *
     * @return array
     */
    public function getZones()
    {
        return $this->callApi('/zones.json', 'zones');
    }

    /**
     * Get the stats for a provided Zone. Note that an ID will generally
     * be something like '12345'. Don't confuse the indexes on the
     * zones array with the zone's actual ID.
     *
     * @param int $id
     * @return array
     */
    public function getZoneStats($id)
    {
        return $this->callApi('/reports/' . $id . '/stats.json', 'stats');
    }

    public function getPopularFiles()
    {
        return $this->callApi('/reports/popularfiles.json', 'popularfiles');
    }

    public function convertSize($size, $unit = '')
    {
        if ((! $unit and $size >= 1<<30) or $unit == 'GB') {
            return number_format($size / (1<<30), 2).'GB';
        }

        if ((! $unit and $size >= 1<<20) or $unit == 'MB') {
            return number_format($size / (1<<20), 2).'MB';
        }

        if ((! $unit and $size >= 1<<10) or $unit == 'KB') {
            return number_format($size / (1<<10), 2) . 'KB';
        }

        return number_format($size) . ' bytes';
    }

    /**
     * Make a call to the MaxCDN API with the provided endpoint, then
     * decode the response and return the data itself.
     *
     * @method callApi
     *
     * @param string $endpoint API URL
     *
     * @return array
     */
    private function callApi($endpoint, $reportType)
    {
        $response = $this->api->get($endpoint);

        return json_decode($response)->data->$reportType;
    }
}