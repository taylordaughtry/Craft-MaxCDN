<?php
namespace Craft;

class MaxCDNPlugin extends BasePlugin
{
	/**
	 * If your plugin name is a proper noun, you shouldn't allow it to be
	 * translated. However, if it's a somewhat generic name, it's a good
	 * idea to wrap the string in Craft::t('JumpStart').
	 *
	 * @return string
	 */
	public function getName()
	{
		 return 'MaxCDN';
	}

	/**
	 * Added in 2.5, this text displays on the Plugins page.
	 *
	 * @return string
	 */
	public function getDescription()
	{
		return 'View stats and purge MaxCDN files right from the Craft CP.';
	}

	/**
	 * This is displayed in the Plugin listing page. Incrementing this does
	 * NOT take the site down for updates, only getSchemaVersion() does that.
	 *
	 * @return string
	 */
	public function getVersion()
	{
		return '0.1.0';
	}

	/**
	 * Increment this if you have new migrations that needto be run.
	 * Craft only takes the site down for updates when you
	 * increment this method.
	 *
	 * @return string
	 */
	public function getSchemaVersion()
	{
		return '1.1.0';
	}

	/**
	 * Self explanatory.
	 *
	 * @return string
	 */
	public function getDeveloper()
	{
		return 'Taylor Daughtry';
	}

	/**
	 * Self explanatory.
	 *
	 * @return string
	 */
	public function getDeveloperUrl()
	{
		return 'https://github.com/taylordaughtry';
	}

	/**
	 * Creates a link to your docs on the Plugins page.
	 *
	 * @return string
	 */
	public function getDocumentationUrl()
	{
		return 'https://github.com/taylordaughtry/Craft-MaxCDN';
	}

	/**
	 * Added in 2.5, plugins can now take part in Craft's update notifications,
	 * and can include their own changelog on the Updates page.
	 *
	 * @return string
	 */
	public function getReleaseFeedUrl()
	{
		return 'https://raw.githubusercontent.com/' .
		'taylordaughtry/craft-maxcdn/master/releases.json';
	}

	/**
	 * Your icon is displayed on the Plugins page, as well as the Settings page
	 * IF your plugin has its own settings.
	 *
	 * @return string
	 */
	public function getIconPath()
	{
		return craft()->path->getPluginsPath().'maxcdn/resources/icon.svg';
	}

	/**
	 * Generates the HTML for your settings. This should almost always return a
	 * template that renders from a twig file.
	 *
	 * @return string
	 */
	public function getSettingsHtml()
	{
		return craft()->templates->render('maxcdn/settings', [
			'settings' => $this->getSettings()
		]);
	}

	/**
	 * Declare the settings for your plugin here. Get these values by calling
	 * $this->getSettings() anywhere in THIS file. If you're trying
	 * to do this in any other file, you'll have to go through the craft
	 * plugins service, like so:
	 *
	 *  craft()->plugins->getPlugin('jumpstart')->getSettings();
	 *
	 * @return array
	 */
	protected function defineSettings()
	{
		return [
			'sample_setting' => array(AttributeType::Mixed, 'default' => ''),
			'alias' => array(AttributeType::String, 'default' => ''),
			'consumerKey' => array(AttributeType::String, 'default' => ''),
			'consumerSecret' => array(AttributeType::String, 'default' => ''),
		];
	}

	/**
	 * If your plugin needs its own item in the Navigation, set this to true. Be
	 * Sure and update the icon-mask.svg file; it's the icon that shows next to
	 * your plugin name in the CP Navigation.
	 *
	 * @return boolean
	 */
	public function hasCpSection()
	{
		return true;
	}

	/**
	 * Make vendors available within your plugin.
	 *
	 * @return string
	 */
	public function init()
	{
		require CRAFT_PLUGINS_PATH.'/maxcdn/vendor/autoload.php';
	}

	/**
	 * Tell Craft where to send our plugin's URLs.
	 *
	 * @method registerCpRoutes
	 *
	 * @return array
	 */
	public function registerCpRoutes()
	{
		return [
			'maxcdn' => ['action' => 'MaxCDN/index'],
			'maxcdn/zones' => ['action' => 'MaxCDN/zones'],
			'maxcdn/cache' => ['action' => 'MaxCDN/cache'],
		];
	}
}