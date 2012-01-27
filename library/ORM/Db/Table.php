<?php
/**
 * @TODO DOCUMENT
 */ 
class Db_Table{
	private $tableName;
	private $columns;
	private $foreignKeys;
	private $identifierColemnName;
	
	private $engine;
	
	const engine_my_isam = "My_ISAM";
	const engine_memory = "MEMORY";
	const engine_csv = "CSV";
	const engine_innodb = "InnoDB";
	public function __construct($tableName = null){
		if (is_null($tableName)) throw new Exception("INVALID TABLE NAME GIVEN IN TABKE CONSTRUCTOR");
		
		$this->tableName = $tableName;
		$this->columns = array();
		$this->identifierColemnName = null;
		$this->relations = null;
		$this->engine = Db_Table::engine_my_isam;
	}
	
	public function getName(){
		return $this->tableName;
	}
	
	public function setName($tableName = null){
		if (is_null($tableName)) throw new Exception("INVALID TABLE NAME GIVEN");
	}

	public function addColumn(Db_Table_Column $column){
		if (! is_null($this->columns[$column->getName()])) throw new Exception("COLUMN -".$column->getName()."- ALLREADY EXIST IN -".$this->tableName."- table");
		$this->columns[$column->getName()] = $column;
		if ($column->isIdentifier()) $this->identifierColemnName = $column->getName();
	}
	
	public function removeColumn($columnName){
		if ($this->columns[$columnName]->isIdentifier()) $this->identifierColemnName = null;
		unset($this->columns[$columnName]);
	}
	
	public function removeAllColumns(){
		$this->columns = array();
	}
	
	public function getColumns(){
		return $this->columns;
	}
	
	public function getColumnNames(){
		return array_keys($this->columns);
	}
	
	/**
	 * gets a specific column by it's name
	 * @return Db_Table_Column
	 */
	public function getColumnByName($name){
		return $this->columns[$name];
	}
	
	/**
	 * gets the identifier column if exists, else null
	 * @return Db_Table_Column
	 */
	public function getIdentifierColumn(){
		if (is_null($this->identifierColemnName)) return null;
		
		return $this->columns[$this->identifierColemnName];
	}
	
	public function hasIdentifier(){
		return (is_null($this->identifierColemnName)?false:true);
	}
	
	public function countColumns(){
		return count($this->columns);
	}
	
	public function setEngine($engine = Db_Table::engine_my_isam){
		$this->engine = $engine;
		
		if (! $this->supportsRelations()) $this->relations = null;
		else $this->removeAllRelations();
	}
	
	public function supportsRelations(){
		switch($this->engine){
			case Db_Table::engine_innodb:
				return true;
			break;
			default:
				return false;
			break;
		}
	}
	
	public function addRelation(Db_Table_Relation $relation){
		$this->relations[] = $relation;
	}
	
	public function removeAllRelations(){
		$this->relations = array();
	}
	
	public function getRelations(){
		return $this->relations;
	}
	
	public function getEnumColumns(){
		if (count($this->columns) == 0) return;
		$columnArray = array();
		foreach ($this->columns as $column){
			//$column = new Db_Table_Column();
			if (strstr($column->getDataType(), "enum")){
				$columnArray[] = $column;
			}
			
		}
		return $columnArray;
	} 
}