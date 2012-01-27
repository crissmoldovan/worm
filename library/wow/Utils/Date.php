<?php
/**
 * Provides some dates handling methods
 * @author Cristian.Moldovan <cristi@ids-team.com>
 * @package WOW_LIB
 * @subpackage UTILS
 * @todo FUTHER DOCS
 */
class Utils_Date{
	private static $longDayName = array("Luni", "Marti", "Miercuri", "Joi", "Vineri", "Sambata", "Duminica");
	private static $shortDayName = array("Lu", "Ma", "Mi", "Jo", "Vi", "Sa", "Du");
	private static $shortMonthNames = array("Ian", "Feb", "Mar", "Apr", "Mai", "Iun", "Iul", "Aug", "Sep", "Oct", "Noi", "Dec");
	private static $longMonthNames = array("Ianuarie", "Februarie", "Martie", "Aprilie", "Mai", "Iunie", "Iulie", "August", "Septembrie", "Octombrie", "Noiembrie", "Decembrie");
	
	public static function dayName($format = "short"){
		switch($format){
			case 'short':
				return self::$shortDayName[date("w")];
			default:
			break;
			case 'long':
				return self::$longDayName[date("w")];
			break;
		}
	}
	
	public static function monthDay(){
		return date("j");
	}
	
	public static function monthName($format = 'short'){
		switch($format){
			case 'short':
				return self::$shortMonthNames[date("n")-1];
			default:
			break;
			case 'long':
				return self::$longMonthNames[date("n")-1];
			break;
		}
	}
	
	public static function year(){
		return date('Y');
	}
	
	public static function formatDate($date){
		$tmp = explode("-", $date);
		$year = $tmp[0];
		$month = (int)$tmp[1];
		$day = $tmp[2];
		
		return $day." ".self::$shortMonthNames[$month-1]." ".$year;
	}
}