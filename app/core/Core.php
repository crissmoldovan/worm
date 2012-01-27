<?php
/**
 * Global core object that will provide basic functionalities like cross module logic
 * @author Cristian.Moldovan <cristi@ids-team.com>
 * @package CORE
 * @todo implement additional method
 * @todo futher docs
 *
 */
class Core{
	private static $localArea = null;
	
	public static function getLocalArea(){
		return Session::get("localArea");
	}
	
	public static function setLocalArea($localAreaID){
		Session::set("localArea", $localAreaID);
	}
	
	public static function hasLocalContext(){
		if (! is_null(Session::get("localArea"))) return true;
		else return false;
	}
}