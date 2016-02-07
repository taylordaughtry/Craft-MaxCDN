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
        $response = $this->callApi('/zones.json', 'zones');

        return $response;
    }

    /**
     * Get the stats for a provided Zone. (Note: an ID will generally
     * be something like '12345'. Don't confuse the indexes on the
     * zones array with the zone's actual ID.)
     *
     * @param int $id
     * @return array
     */
    public function getZoneStats($id)
    {
        $response = $this->callApi('/reports/' . $id . '/stats.json', 'stats');

        return $response;
    }

    public function getPopularFiles()
    {
        $response = $this->callApi('/reports/popularfiles.json', 'popularfiles');

        return $response;
    }

    /**
     * Make a call to the MaxCDN API with the provided endpoint, then
     * decode the response and return the data itself.
     *
     * @method callApi
     *
     * @param [type] $endpoint [description]
     *
     * @return [type] [description]
     */
    private function callApi($endpoint, $reportType)
    {
        $response = $this->api->get($endpoint);

        return json_decode($response)->data->$reportType;
    }
}