
<?php

/**
* 
*
* @author Techlark ORM <orm@techlark.com>
* @package Mappers
* @subpackage 
* @version 1
* @date: 2011-10-20
*/

class App_Info_Mapper extends Model_Mapper_Abstract {

	private static $mappedClass = "App_Info";
	private static $tableName = App_Info::table_name;
	private static $instance = null;
	
	/**
	 * @return App_Info_Mapper
	 */
	public static function getInstance(){
		if (is_null(self::$instance)) {
			self::$instance = new App_Info_Mapper(self::$tableName, self::$mappedClass);
		}
		
		return self::$instance;
	}
	
}

?>