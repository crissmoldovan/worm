<?php
/**
 * @TODO DOCUMENT
 */ 
class Db_Connector_Factory{
	
	/**
	 * 
	 * @param array $connectionData
	 * @return Db_Connector
	 */
	public static function create($connectionData = null){
		return new Db_Connector($connectionData);	
	}
}