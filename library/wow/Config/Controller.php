<?php
/**
 * 
 * @author Cristian Moldovan <cristi@ids-team.com>
 * @package Wow
 * @subpackage Config
 * 
 * The class offers an alternative to zend registry to store app configs values.
 * 		- it provides some methods to handle values of this config
 *
 */
class Config_Controller{
	/**
	 * stores the values as a stativ property of the class
	 * @var array
	 */
	private static $config = array();
	
	/**
	 * Sets a value for a section;
	 * 	eg.  for the main confog we will use the "main_config" key and set the app's general config as value
	 * @param string $name
	 * @param object $value
	 */
	public static function setSection($name = null, $value=null){
		if (is_null($name) || trim($name) == "") return;
		self::$config[$name] = $value;
	}
	
	/**
	 * Retrives a section from the config array
	 * @param string $name
	 * @return Mixed
	 */
	public static function getSection($name = null){
		return self::$config[$name];
	}
	
	/**
	 * gets a value for a key from a specified section
	 * @param string $name
	 * @param string $key
	 * @return Mixed
	 */
	public static function getValueFromSection($name = null, $key = null){
		return self::$config[$name][$key];
	}
	
	/**
	 * retrives al keys for a section
	 * @param string $name
	 * @return Mixed
	 */
	public static function getKeysForSection($name = null){
		if (is_null($name) || !key_exists($name, self::$config)) return null;
		
		if (! is_array(self::$config[$name])) return null;
		
		return array_keys(self::$config);
	}
}