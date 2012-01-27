<?php
/**
 * PATH to Modules and controllers helper
 * @author Cristian.Moldovan <cristi@ids-team.com>
 * @package WOW_LIB
 * @subpackage UTILS
 * @todo FUTHER DOCS
 */
class Utils_Path{
	public static function getModuleName(){
		return str_replace("/modules/", "", str_replace(APPLICATION_PATH, "", Zend_Controller_Front::getInstance()->getModuleDirectory()));
	}
	
	public static function getControllerName(){
		$front = Zend_Controller_Front::getInstance();
		return $front->getRequest()->getControllerName();
	}
}