<?php
/**
 * @TODO DOCUMENT
 */ 
class Db_Connector{
	private $connectionData = null;
	private $zendConnectorInstance = null;
	
	public function __construct($connectionData = NULL) {
		if (get_class($connectionData) == "Db_Host") $connectionData = $connectionData->toArray();
		
		if (is_null($connectionData) || ! is_array($connectionData) || empty($connectionData)) throw new Exception("Invalid ORM Connector DATA");
		
		$this->zendConnectorInstance = Zend_Db::factory($connectionData["connector"], array(
					    'host'     => $connectionData["host"],
					    'username' => $connectionData["user"],
					    'password' => $connectionData["pass"],
					    'dbname'   => $connectionData["schema"],
						'charset'  => $connectionData["charset"]
					));
	
	}
	
	public function getConnectorData(){
		return $this->connectionData;
	}
	
	public function setConnectorData($data){
		$this->connectionData = $data;
	}
	
	public function getConnector(){
		return $this->zendConnectorInstance;
	}
}