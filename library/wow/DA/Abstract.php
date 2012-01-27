<?php
/**
 * DA abstract class
 * 		 - has the basic data handling methods implemented
 * 
 * @author Cristian.Moldovan <cristi@ids-team.com>
 * @package WOW_LIB
 * @subpackage DA
 */
abstract class DA_Abstract{
	/**
	 * @var Zend_Db_Adapter_Abstract database connector instance
	 */
	protected $db = null;
	
	/**
	 * @var string for local table usage; the obects that will extend this class will have to pass the table name through the constructor
	 */
	private static $a_tableName = null;
	
	/**
	 * @param string $tableName the table name that the class extendin this abstract class will use for querying
	 */
	public function __construct($tableName){
		$this->a_tableName = $tableName;
		$this->initDb();
	}
	
	/**
	 * Sets up the connector for the db; will invoke the private initDb function that will do the actual Zend_Db instantiation
	 * @param string $tableName
	 */
	public function init($tableName = null){
		$this->a_tableName = $tableName;
		$this->initDb();	
	}
	
	/**
	 * Initiates a Zend_Db object
	 */
	protected function initDb(){
		$cfg = Config_Controller::getSection("db");
		$this->db = Zend_Db::factory($cfg["connector"], array(
					    'host'     => $cfg["host"],
					    'username' => $cfg["user"],
					    'password' => $cfg["pass"],
					    'dbname'   => $cfg["schema"],
						'charset'  => $cfg["charset"]
					));
	}
	
	/**
	 * counts records for a given set of filters
	 *  - the $filters array must be have the following format:
	 *  		array(
	 *  			array("field"=>"field_name", "compare"=>"LIKE", "value"=>"some_value")
	 *  		);
	 *  - you can have multiple filters nested inside the $filtes array
	 *  - compare attribute is optional and if it's not passed it is assumed as " = "; you must use only valid SQL comparison operators
	 * @param array $filters
	 */
	public function countRecords($filters = null){
		if (is_null($this->db)){
			$this->initDb();
		}
		
		// attach filters
		
		$statement= $this->db->select()->from($this->a_tableName, array("nr" => " count(*) "));
		if (is_array($filters) && ! empty($filters)){
			foreach($filters as $filter){
				if (is_null($filter["compare"])) $filter["compare"] = " = ";
				if (! is_null($filter["field"]) && ! is_null($filter["value"])){
					$statement = $statement->where($filter["field"]." ".$filter["compare"]." ".$filter["value"]);
				}
			}
		}
				
		$result = $statement->query()->fetchAll();
		return $result[0]["nr"];
	}
	
	/**
	 * gets records for a given set of filters
	 *  - the $orde
	 *  
	 * @param array $filters
	 *	the $filters array must be have the following format:
	 *  		array(
	 *  			array("field"=>"field_name", "compare"=>"LIKE", "value"=>"some_value")
	 *  		);
	 *  you can have multiple filters nested inside the $filtes array
	 *  compare key is optional and if it's not passed it is assumed as " = "; you must use only valid SQL comparison operators
	 *  
	 * @param array $order
	 * the $order array must have the following format:
	 *  		array("field"=>"field_name", "dir"=>"ASC")
	 * - the "dir" key is optional, if not provide it will be assumed as "ASC"
	 * 
	 * @param array $limit
	 *  the $limit array must have the following format:
	 *  		array("offset" => 10, "limit"=>5)
	 *  - the offset key is optional; if not set, than it will be consedered 0
	 *  
	 * @param string $group @todo establish if needed
	 */
	public function filter($filters = null, $order = null, $limit = null, $group = null){
		if (is_null($this->db)){
			$this->initDb();
		}
		
		// attach filters
		
		$statement= $this->db->select()->from($this->a_tableName);
		if (is_array($filters) && ! empty($filters)){
			foreach($filters as $filter){
				if (is_null($filter["compare"])) $filter["compare"] = " = ";
				if (! is_null($filter["field"]) && ! is_null($filter["value"])){
					$statement = $statement->where($filter["field"]." ".$filter["compare"]." '".$filter["value"]."' ");
				}
			}
		}
		
		// add order
		if (! is_null($order) && is_array($order) && !empty($order)){
			if ($order["dir"] == "") $order["dir"] = "ASC";
			$statement = $statement->order($order["field"]." ".$order["dir"]);
		}
		
		// add limit clause
		if (! is_null($limit) && is_array($limit) && !empty($limit)){
			$limitString = "";
			if (! is_null($limit["offset"]) && $limit["offset"] != "" && $limit["offset"] != "0" ){
				$limitString = $limit["offset"].", ";
			}
			
			$limitString .= $limit["count"];
			
			$statement = $statement->limit($limitString);
		}
		
		Logger::write($statement->__toString());
		
		// add group clause
		if (! is_null($group)){
			$statement = $statement->group($group);
		}
		
		$result = $statement->query()->fetchAll();
		return $result;
	}
	
	/**
	 * Updates a record identified by the $id param with the data in $fields array 
	 * @param array $fields string indexed array witch must have the key as the table's column names @todo CLARIFY
	 * @param integer $id identifier for the updated record
	 */
	public function update($fields = null, $id = null){
		if (is_null($this->db)){
			$this->initDb();
		}
		
		if (! is_array($fields) || empty($fields) || is_null($id)) return;
		
		$this->db->update($this->a_tableName, $fields, " id = ".$id);
	}
	
	/**
	 * Adds a new record to the db. @TODO CLARIFY
	 * @param array $fields
	 */
	public function insert($fields = null){
		if (is_null($this->db)){
			$this->initDb();
		}
		
		if (! is_array($fields) || empty($fields)) return;
		
		$this->db->insert($this->a_tableName, $fields);
		
		return $this->db->lastInsertId();
	}
	
	/**
	 * Deletes a record specified by the $id param
	 * @param integer $id
	 */
	public function delete($id = null){
		if (is_null($this->db)){
			$this->initDb();
		}
		
		if (is_null($id)) return;
		
		$this->db->delete($this->a_tableName, " id = ".$id);
	}
}
?>
