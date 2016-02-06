<?php
namespace Craft;

class MaxCDNService extends BaseApplicationComponent
{
    protected $settings;
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

    public function getZones()
    {
        $response = $this->callApi('/zones.json');

        return $response->zones;
    }

    private function callApi($endpoint)
    {
        $response = $this->api->get($endpoint);

        return json_decode($response)->data;
    }
}