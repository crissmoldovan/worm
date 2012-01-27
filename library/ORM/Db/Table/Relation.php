<?php
/**
 * @TODO DOCUMENT
 */ 
class Db_Table_Relation{
	private $tableName;
	private $name;
	private $columnName;
	private $referencedSchema;
	private $referencedTable;
	private $referencedColumnName;
	
	public function __construct(){
		
	}
	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return the $columnName
	 */
	public function getColumnName() {
		return $this->columnName;
	}

	/**
	 * @return the $referencedSchema
	 */
	public function getReferencedSchema() {
		return $this->referencedSchema;
	}

	/**
	 * @return the $referencedTable
	 */
	public function getReferencedTable() {
		return $this->referencedTable;
	}

	/**
	 * @return the $referencedColumnName
	 */
	public function getReferencedColumnName() {
		return $this->referencedColumnName;
	}

	/**
	 * @param $name the $name to set
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @param $columnName the $columnName to set
	 */
	public function setColumnName($columnName) {
		$this->columnName = $columnName;
	}

	/**
	 * @param $referencedSchema the $referencedSchema to set
	 */
	public function setReferencedSchema($referencedSchema) {
		$this->referencedSchema = $referencedSchema;
	}

	/**
	 * @param $referencedTable the $referencedTable to set
	 */
	public function setReferencedTable($referencedTable) {
		$this->referencedTable = $referencedTable;
	}

	/**
	 * @param $referencedColumnName the $referencedColumnName to set
	 */
	public function setReferencedColumnName($referencedColumnName) {
		$this->referencedColumnName = $referencedColumnName;
	}
	
	

	/**
	 * @return the $tableName
	 */
	public function getTableName() {
		return $this->tableName;
	}

	/**
	 * @param field_type $tableName
	 */
	public function setTableName($tableName) {
		$this->tableName = $tableName;
	}

	public function setFromDefinition($definition = null){
		if (is_null($definition) || ! is_array($definition)) throw new Exception("INVALID RELATION DEFINITION PASSED");
		
		$this->name 					= $definition["CONSTRAINT_NAME"];
		$this->tableName				= $definition["TABLE_NAME"];
		$this->columnName 				= $definition["COLUMN_NAME"];
		$this->referencedSchema 		= $definition["REFERENCED_TABLE_SCHEMA"];
		$this->referencedTable 			= $definition["REFERENCED_TABLE_NAME"];
		$this->referencedColumnName 	= $definition["REFERENCED_COLUMN_NAME"];
	}
	
}