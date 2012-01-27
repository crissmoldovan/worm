<?php
/**
 * @TODO DOCUMENT
 */ 
class Db_Table_Reader{
	
	public static function readColumns($connection = null, Db_Table $table){
		if (is_null($connection)) throw new Exception("INVALID CONNECTION PASSED FOR COLUMN READING");
		
		$result = $connection->describeTable($table->getName());
		
		if (count($result)){
			foreach ($result as $columnName => $columnDefinition){
				$column = new Db_Table_Column($columnName);
				$column->setFromDefinition($columnDefinition);
				$table->addColumn($column);
			}
		}
		
	}
	
	public static function getEngine($connection = null, Db_Table $table = null){
		if (is_null($connection) || is_null($table)) throw new Exception("INVALID CONNECTION OR TABLE NAME PASSED TO LOAD ENGINE");
		$config = $connection->getConfig();
		$result = $connection->query(' select ENGINE from `information_schema`.`TABLES` where TABLE_NAME like "'.$table->getName().'" and TABLE_SCHEMA like "'.$config["dbname"].'" ')->fetchAll();
		
		$table->setEngine($result[0]["ENGINE"]);
	}
	
	public static function readForeignKeys($connection = null, Db_Table &$table = null){
		if (is_null($connection) || is_null($table)) throw new Exception("INVALID CONNECTION OR TABLE NAME PASSED TO LOAD FOREIGN KEYS");
		
		$config = $connection->getConfig();
		
		$statement = '
			select 
				CONSTRAINT_NAME,
				COLUMN_NAME,
				TABLE_NAME,
				REFERENCED_TABLE_SCHEMA,
				REFERENCED_TABLE_NAME,
				REFERENCED_COLUMN_NAME
			from `information_schema`.`KEY_COLUMN_USAGE` 
			where TABLE_NAME like "'.$table->getName().'" 
			and TABLE_SCHEMA like "'.$config["dbname"].'" 
			and CONSTRAINT_NAME NOT LIKE "PRIMARY"
		';
		
		$result = $connection->query($statement)->fetchAll();
		
		if (count($result)){
			foreach ($result as $relationDefinition){
				$relation = new Db_Table_Relation();
				$relation->setFromDefinition($relationDefinition);
				$table->addRelation($relation);
			}
		}
		
		// refferencing fk's
		
		
	$statement = '
			select 
				CONSTRAINT_NAME,
				COLUMN_NAME,
				REFERENCED_TABLE_SCHEMA,
				TABLE_NAME,
				REFERENCED_TABLE_NAME,
				REFERENCED_COLUMN_NAME
			from `information_schema`.`KEY_COLUMN_USAGE` 
			where REFERENCED_TABLE_NAME like "'.$table->getName().'" 
			and TABLE_SCHEMA like "'.$config["dbname"].'" 
			and CONSTRAINT_NAME NOT LIKE "PRIMARY"
		';
		
		$result = $connection->query($statement)->fetchAll();
		
		if (count($result)){
			foreach ($result as $relationDefinition){
				$relation = new Db_Table_Relation();
				$relation->setFromDefinition($relationDefinition);
				$table->addRelation($relation);
			}
		}
	}
}