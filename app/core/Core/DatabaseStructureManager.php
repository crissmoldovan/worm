<?php
class Core_DatabaseStructureManager{
	
	public static function readTableStructure($connectionName = null, $tableName = null){
		if (is_null($tableName)) {
			throw new Exception("NULL TABLE NAME PASSED ".__CLASS__."->".__METHOD__);
		}
		
		if (is_null($connectionName)) {
			throw new Exception("NULL CONNACTION NAME PASSED ".__CLASS__."->".__METHOD__);
		}
		
		if (! Connection_Manager::isConnectionWithNameAvailable($connectionName)){
			throw new Exception("CONNECTION WITH NAME -".$connectionName."- IS NOT AVAILABLE IN ".__CLASS__."->".__METHOD__);
		}
		
		return Db_Reader::readTable(Connection_Manager::getByName($connectionName), $tableName);
	}
	
	public static function getAvailableTablesForConection($connectionName = null){
		if (is_null($connectionName)) {
			throw new Exception("NULL CONNACTION NAME PASSED ".__CLASS__."->".__METHOD__);
		}
		
		if (! Connection_Manager::isConnectionWithNameAvailable($connectionName)){
			throw new Exception("CONNECTION WITH NAME -".$connectionName."- IS NOT AVAILABLE IN ".__CLASS__."->".__METHOD__);
		}
		
		return Db_Reader::readTableNames(Connection_Manager::getByName($connectionName));
	}
}