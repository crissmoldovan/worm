
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

class Db_Host_Mapper extends Model_Mapper_Abstract {

	private static $mappedClass = "Db_Host";
	private static $tableName = Db_Host::table_name;
	private static $instance = null;
	
	/**
	 * @return Db_Host_Mapper
	 */
	public static function getInstance(){
		if (is_null(self::$instance)) {
			self::$instance = new Db_Host_Mapper(self::$tableName, self::$mappedClass);
		}
		
		return self::$instance;
	}
	
}

?>