<?php
/**
 * URL utility lib
 * @author Cristian.Moldovan <cristi@ids-team.com>
 * @package WOW_LIB
 * @subpackage UTILS
 * @todo FUTHER DOCS
 */
class Utils_Url{
		
		public static function strToUrl($text = null){
				$text=strtolower($text);
				$code_entities_match = array(' ','--','&quot;','!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','.','/','*','+','~','`','=');
				$code_entities_replace = array('-','-','','','','','','','','','','','','','','','','','','','','','','','','');
				$text = str_replace($code_entities_match, $code_entities_replace, $text);
				return $text;
		}
	} 
?>