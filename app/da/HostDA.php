<?php

class HostDA extends DA_Abstract{
	
	private static $tableName = Db_Host::table_name;
	private static $instance = null;
	
	
	/**
	 * @return HostDA
	 */
	public static function getInstance(){
		if (is_null(self::$instance)) {
			self::$instance = new HostDA(self::$tableName);
		}
		
		return self::$instance;
	}
}