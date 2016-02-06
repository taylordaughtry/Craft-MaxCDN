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
        $response = $this->callApi('/zones.json');

        return $response->zones;
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
    private function callApi($endpoint)
    {
        $response = $this->api->get($endpoint);

        return json_decode($response)->data;
    }
}