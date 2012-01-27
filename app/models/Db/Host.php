
<?php

/**
* 
*
* @author Techlark ORM <orm@techlark.com>
* @package models
* @subpackage 
* @version 1
* @date: 2011-10-20
*/

class Db_Host {

	
	
	/**
	 * 
	 * @var integer
	 */
	private $id;
	
	/**
	 * 
	 * @var string
	 */
	private $host;
	
	/**
	 * 
	 * @var string
	 */
	private $port;
	
	/**
	 * 
	 * @var string
	 */
	private $name;
	
	/**
	 * 
	 * @var string
	 */
	private $user;
	
	/**
	 * 
	 * @var string
	 */
	private $pass;
	
	/**
	 * 
	 * @var string
	 */
	private $schema;
	
	/**
	 * 
	 * @var string
	 */
	private $connector;
	
	/**
	 * 
	 * @var string
	 */
	private $unique_name;
	/**
	 * 
	 * @var string
	 */
	const table_name = 'db_host';
		
	/**
	* Converts the current object to an array and string some properties if param $exclude is true
	* 
	* @param boolean $exclude
	*/
	public function toArray($exclude = true){
		$result = array();
		foreach($this as $key => $value){
			if($exclude){
				if ($key!="id"){
					$result[$key] = $value;
				}
			}else{
				$result[$key] = $value;
			}
		}
			
		return $result;
	}

	/**
	 * Sets the current object's properties from a given array (usually a result of an db query)
	 * 
	 * @param array $rs
	 */
	public function setFromRS($rs = null){
		if (! is_null($rs)){
			foreach($this as $key => $value){
				if (! is_null($rs[$key])) $this->$key = $rs[$key];
			}
		}
	}
	
	/**
	* @return Db_Host_Mapper
	*/
	public function getMapper(){
		return Db_Host::staticGetMapper();
	}
	
	/**
	* @return Db_Host_Mapper
	*/
	public static function staticGetMapper(){
		return Db_Host_Mapper::getInstance();
	} 
	
	public function save(){
		$mapper = $this->getMapper();
		if ($this->id == null){
			$this->id = $mapper->insert($this->toArray());
		}else{
			$mapper->update($this->toArray(), $this->id);
		}
	}
	
	/**
	 *  gets the id attribute	 * 
	 * @param integer $id
	 * @return integer
	 */
	public  function getId($id = ''){
		return $this->id;
	}

	/**
	 *  gets the host attribute	 * 
	 * @param string $host
	 * @return string
	 */
	public  function getHost($host = ''){
		return $this->host;
	}

	/**
	 *  gets the port attribute	 * 
	 * @param string $port
	 * @return string
	 */
	public  function getPort($port = ''){
		return $this->port;
	}

	/**
	 *  gets the name attribute	 * 
	 * @param string $name
	 * @return string
	 */
	public  function getName($name = ''){
		return $this->name;
	}

	/**
	 *  gets the user attribute	 * 
	 * @param string $user
	 * @return string
	 */
	public  function getUser($user = ''){
		return $this->user;
	}

	/**
	 *  gets the pass attribute	 * 
	 * @param string $pass
	 * @return string
	 */
	public  function getPass($pass = ''){
		return $this->pass;
	}

	/**
	 *  gets the schema attribute	 * 
	 * @param string $schema
	 * @return string
	 */
	public  function getSchema($schema = ''){
		return $this->schema;
	}

	/**
	 *  gets the connector attribute	 * 
	 * @param string $connector
	 * @return string
	 */
	public  function getConnector($connector = ''){
		return $this->connector;
	}

	/**
	 *  gets the unique_name attribute	 * 
	 * @param string $unique_name
	 * @return string
	 */
	public  function getUniqueName($unique_name = ''){
		return $this->unique_name;
	}

	/**
	 *  sets the id attribute	 * 
	 * @param integer $id
	 * @return integer
	 */
	public  function setId($id = ''){
		$this->id = $id;
	}

	/**
	 *  sets the host attribute	 * 
	 * @param string $host
	 * @return string
	 */
	public  function setHost($host = ''){
		$this->host = $host;
	}

	/**
	 *  sets the port attribute	 * 
	 * @param string $port
	 * @return string
	 */
	public  function setPort($port = ''){
		$this->port = $port;
	}

	/**
	 *  sets the name attribute	 * 
	 * @param string $name
	 * @return string
	 */
	public  function setName($name = ''){
		$this->name = $name;
	}

	/**
	 *  sets the user attribute	 * 
	 * @param string $user
	 * @return string
	 */
	public  function setUser($user = ''){
		$this->user = $user;
	}

	/**
	 *  sets the pass attribute	 * 
	 * @param string $pass
	 * @return string
	 */
	public  function setPass($pass = ''){
		$this->pass = $pass;
	}

	/**
	 *  sets the schema attribute	 * 
	 * @param string $schema
	 * @return string
	 */
	public  function setSchema($schema = ''){
		$this->schema = $schema;
	}

	/**
	 *  sets the connector attribute	 * 
	 * @param string $connector
	 * @return string
	 */
	public  function setConnector($connector = ''){
		$this->connector = $connector;
	}

	/**
	 *  sets the unique_name attribute	 * 
	 * @param string $unique_name
	 * @return string
	 */
	public  function setUniqueName($unique_name = ''){
		$this->unique_name = $unique_name;
	}

}

?>