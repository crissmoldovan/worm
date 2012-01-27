<?php
/**
 * @TODO DOCUMENT
 */ 

class Db_Reader{
	public static function readTableNames($connection = null){
		
		if (is_null($connection)) throw new Exception("INVALID CONNECTOR PASSED TO LOAD TABLE NAMES...");
		$result = $connection->listTables();
		return $result;
	}
	
	public function readTableFields($connection = null, Db_Table $table = null){
		if (is_null($connection) || is_null($table)) throw new Exception("INVALID CONNECTION OR TABLE NAME PASSED TO LOAD FIELDS");
		
		$fields = Db_Table_Reader::readColumns($connection, $table);
	}
	
	public static function readTable($connection = null, $tableName = null){
		if (is_null($connection) || is_null($tableName)) throw new Exception("INVALID CONNECTION OR TABLE NAME PASSED TO READ TABLE");
		
		$table = new Db_Table($tableName);
		
		Db_Table_Reader::readColumns($connection, &$table);
		Db_Table_Reader::getEngine($connection, $table);
		
		if ($table->supportsRelations()){
			Db_Table_Reader::readForeignKeys($connection, $table);
		}
		return $table;
	}
	
	
}