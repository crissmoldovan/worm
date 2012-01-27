<?php
/**
 * Class that defines a Logger object that would log debug messeges to a file or send them to FireBug Console 
 * @author Cristian Moldovan <cristi@ids-team.com>
 * @package WOW_LIB
 * @subpackage UTILS
 * @todo FUTHER DOCS
 */

class Logger{
	private static $_fileLogger = null;
	private static $_firebugLogger = null;
	
	private static $_isInited = false;
	private static $_isFileInited = false;
	private static $_isFbInited = false;
	
	private function __construct(){
		return null;
	}
	
	private static function init(){
		$loggerConfig = Config_Controller::getValueFromSection("main", "logger");
		if ($loggerConfig["enable"]){
			// init the FB logger
			if ($loggerConfig["logToFirebug"]){
				try{
					$fbWriter = new Zend_Log_Writer_Firebug();
					self::$_firebugLogger = new Zend_Log($fbWriter);
					self::$_isFbInited = true;
					self::$_isInited = true;
				}
				catch (Exception $ex){
					// do nothing
				}
			}
			
			//init the file logger
			if (! is_null($loggerConfig["logFile"])){
				try{
					$writer = new Zend_Log_Writer_Stream($loggerConfig["logFile"]);
					self::$_fileLogger = new Zend_Log($writer);
					self::$_isInited = true;
					self::$_isFileInited = true;
				}
				catch (Exception $ex){
					// do nothing					
				}
			}
		}
	}
	
	/**
	 * used for custom debugging to a file
	 * @param $object
	 */
	public static function write($object){
		if (! is_null($object)){
			if (! self::$_isInited) self::init();
			ob_start();
			if (!is_scalar($object))
			{
				print_r($object);
			}
			else 
			{
				echo $object;
			}
			
			$output = ob_get_contents();
			ob_end_clean();
			
			if (self::$_isFileInited) self::$_fileLogger->log($output, Zend_Log::INFO);
			if (self::$_isFbInited) self::$_firebugLogger->log($object, Zend_Log::INFO);
		}
	}
}
?>