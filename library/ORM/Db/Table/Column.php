<?php
/**
 * @TODO DOCUMENT
 */ 
class Db_Table_Column{
	private $name;
	private $tableName;
	private $position;
	private $dataType;
	private $default;
	private $nullable;
	private $length;
	private $precision;
	private $unsigned;
	private $primary;
	private $primaryPosition;
	private $identity;
	
	public function __construct($name = null){
		if (is_null($name)) throw new Exception("INVALID COLUMN NAME PASSED IN CONSTRUCTOR");
		
		$this->name = $name;
		$this->position = 0;
		$this->dataType = "varchar";
		$this->default = null;
		$this->nullable = true;
		$this->length = 45;
		$this->primary = false;
		$this->identity = false;
	}
	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return the $tableName
	 */
	public function getTableName() {
		return $this->tableName;
	}

	/**
	 * @return the $position
	 */
	public function getPosition() {
		return $this->position;
	}

	/**
	 * @return the $dateType
	 */
	public function getDataType() {
		return $this->dataType;
	}

	/**
	 * @return the $default
	 */
	public function getDefault() {
		return $this->default;
	}

	/**
	 * @return the $nullable
	 */
	public function getNullable() {
		return $this->nullable;
	}

	/**
	 * @return the $length
	 */
	public function getLength() {
		return $this->length;
	}

	/**
	 * @return the $precision
	 */
	public function getPrecision() {
		return $this->precision;
	}

	/**
	 * @return the $unsigned
	 */
	public function getUnsigned() {
		return $this->unsigned;
	}

	/**
	 * @return the $primary
	 */
	public function getPrimary() {
		return $this->primary;
	}

	/**
	 * @return the $primaryPosition
	 */
	public function getPrimaryPosition() {
		return $this->primaryPosition;
	}

	/**
	 * @return the $identity
	 */
	public function getIdentity() {
		return $this->identity;
	}

	/**
	 * @param $name the $name to set
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @param $tableName the $tableName to set
	 */
	public function setTableName($tableName) {
		$this->tableName = $tableName;
	}

	/**
	 * @param $position the $position to set
	 */
	public function setPosition($position) {
		$this->position = $position;
	}

	/**
	 * @param $dataType the $dataType to set
	 */
	public function setDataType($dataType) {
		$this->dataType = $dataType;
	}

	/**
	 * @param $default the $default to set
	 */
	public function setDefault($default) {
		$this->default = $default;
	}

	/**
	 * @param $nullable the $nullable to set
	 */
	public function setNullable($nullable) {
		$this->nullable = $nullable;
	}

	/**
	 * @param $length the $length to set
	 */
	public function setLength($length) {
		$this->length = $length;
	}

	/**
	 * @param $precision the $precision to set
	 */
	public function setPrecision($precision) {
		$this->precision = $precision;
	}

	/**
	 * @param $unsigned the $unsigned to set
	 */
	public function setUnsigned($unsigned) {
		$this->unsigned = $unsigned;
	}

	/**
	 * @param $primary the $primary to set
	 */
	public function setPrimary($primary) {
		$this->primary = $primary;
	}

	/**
	 * @param $primaryPosition the $primaryPosition to set
	 */
	public function setPrimaryPosition($primaryPosition) {
		$this->primaryPosition = $primaryPosition;
	}

	/**
	 * @param $identity the $identity to set
	 */
	public function setIdentity($identity) {
		$this->identity = $identity;
	}

	/**
	 * sets the currents column infos from the array returned by the descriptor
	 * @param $columnDefinition
	 */
	public function setFromDefinition($columnDefinition = array()){
		if (is_null($columnDefinition)) return;
		
		$this->tableName = $columnDefinition["TABLE_NAME"];
	    $this->position = $columnDefinition["COLUMN_POSITION"];
	    $this->dataType = $columnDefinition["DATA_TYPE"];
	    $this->default = $columnDefinition["DEFAULT"];
	    $this->nullable = $columnDefinition["NULLABLE"];
	    $this->length = $columnDefinition["LENGTH"];
	    $this->precision = $columnDefinition["PRECISION"];
	    $this->unsigned = $columnDefinition["UNSIGNED"];
	    $this->primary = $columnDefinition["PRIMARY"];
	    $this->primaryPosition = $columnDefinition["PRIMARY_POSITION"];
	    $this->identity = $columnDefinition["IDENTITY"];
	}
	
	public function isIdentifier(){
		return $this->identity;
	}
	
	public function isNullable(){
		return $this->nullable;
	}
	
	public function getEnumValues(){
		if (! strstr($this->getDataType(), "enum")) throw new Exception("COLUMN ".$this->getName()." is not ENUM typed");
		
		$value = str_replace(array("enum(", ")"), "", $this->getDataType());
		$valuesArray = explode(",",$value);
		$values = array();
		if (count($valuesArray)){
			foreach ($valuesArray as $valueItem){
				$values[] = str_replace(array("'", '"'), "", $valueItem);
			}
			return $values;
		}else{
			return null;
		}
	}
}