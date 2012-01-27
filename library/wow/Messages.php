<?php
/**
 * Provides message storage system
 * @author Cristian.Moldovan <cristi@ids-team.com>
 * @package WOW_LIB
 * @subpackage UTILS
 * @todo FUTHER DOCS
 */
class Messages{
	private static $list = array();
	const notification = "NOTIFICATION";
	const error = "ERROR";
	const success = "SUCCESS";
	const warning = "WARNING";
	
	public static function add($message = '', $type = self::notification){
		self::$list[] = array("text" => $message, "type" => $type);
	}
	
	public static function getAll(){
		return self::$list;
	}
	
	public static function getAll_Clear(){
		$result = self::$list;
		self::clear();
		return $result;
	}
	
	public static function clear(){
		self::$list = array();
	}
}