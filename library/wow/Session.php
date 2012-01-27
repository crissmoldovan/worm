<?php
/**
 * Wrapper over the SESSION objects (Uses Zend_Session lib)
 * @author Cristian.Moldovan <cristi@ids-team.com>
 * @package WOW_LIB
 * @subpackage UTILS
 * @todo FUTHER DOCS
 */
class Session{
	private static $session = null;
	
	public static function init(){
		self::$session = new Zend_Session_Namespace('belmarel');
	}
	
	public static function get($key = null){
		if (is_null(self::$session)) self::init();
		if (is_null($key)) return null;

		return self::$session->$key;
	}
	
	public static function set($key = null, $value = null){
		if (is_null(self::$session)) self::init();
		if (is_null($key)) {
			throw new Exception("SESSION - Tried to set value on an empty session key");
			return null;
		}
		
		self::$session->$key = $value;
	}
}