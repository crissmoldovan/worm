<?php
class Connection_Manager{
	private static $connectionListByID = array();
	private static $connectionListByName = array();
	
	private static $connectionDefinitions = array();
	
	
	/**
	 * Retrieves a connection by its id
	 * @param integer $connectionID
	 */
	public static function getByID($connectionID){
		
		if (array_key_exists($connectionID, self::$connectionListByID)) return self::$connectionListByID[$connectionID];
		else return null;	
	}
	
	/**
	 * Retrieves a connection by its name
	 * @param string $connectionName
	 * 
	 */
	public static function getByName($connectionName){
		if (array_key_exists($connectionName, self::$connectionListByName)) return self::$connectionListByName[$connectionName];
		else return null;	
	}
	
	/**
	 * Creates a new Db_Connection object and mapps it internally
	 * @param array $connectionData
	 */
	public static function initConnection($connectionData){
		if (get_class($connectionData)=="Db_Host") $connectionData = $connectionData->toArray();
		try{
			$instance = Db_Connector_Factory::create($connectionData);
			self::$connectionListByID[$connectionData["id"]] = $instance->getConnector();
			self::$connectionListByName[$connectionData["unique_name"]] = $instance->getConnector();
		}
		catch (Exception $ex){
			Logger::write("COULD NOT INITIATE DB CONNECTION:");
			Logger::write("     - ".$ex->getMessage());
			Logger::write("     - connectionData:");
			Logger::write($connectionData);
			Logger::write("---------------------------------");
		} 
	}
	
	public static function initFromConfig($connectionConfigData){
		
		self::$connectionDefinitions = $connectionConfigData;
		
		if (is_null(self::$connectionDefinitions) || ! is_array(self::$connectionDefinitions) || empty(self::$connectionDefinitions)) throw new Exception("Invalid Connections List");
		
		if (count(self::$connectionDefinitions)){
			foreach (self::$connectionDefinitions as $key => $connectionData){
				$connectionData["id"] = $key;
				self::initConnection($connectionData);
			}
		}
	}
	/**
	 * Inits a list of connectors given by an array of config objects
	 * @param array[][] $connectionDataList
	 */
	public static function initFromList($connectionDataList){
		
		if (is_null($connectionDataList) || ! is_array($connectionDataList) || empty($connectionDataList)) throw new Exception("Invalid Connections List");
		
		if (count($connectionDataList)){
			foreach ($connectionDataList as $connectionData){
				self::initConnection($connectionData);
			}
		}
	}
	
	/**
	 * Gets all available connection IDs
	 * @return array[]
	 */
	public static function getAllAvailableConnectionIDs(){
		return array_keys(self::$connectionListByID);
	}
	
	/**
	 * Gets all available connection Names
	 * @return array[] 
	 */
	public static function getAllAvailableConnectionNames(){
		return array_keys(self::$connectionListByName);
	}
	
	
	public static function isConnectionWithIDAvailable($id = null){
		if (! is_null($id) || array_key_exists($id, self::$connectionListByID) && ! is_null(self::$connectionListByID[$id])) return true;
		return false;
	}
	
	public static function isConnectionWithNameAvailable($name = null){
		if (! is_null($name) && array_key_exists($name, self::$connectionListByName) && ! is_null(self::$connectionListByName[$name])) return true;
		return false;
	}
	
	public static function getAllConnections(){
		return self::$connectionListByID;
	}
	
	public static function getAllConnectionsDefinitions(){
		return self::$connectionDefinitions;;
	}
	
}