<?php
/**
 * Host front controller
 * 
 * @author Cristian.Moldovan <cristi@ids-team.com>
 * @package MODULES
 * @subpackage HOST
 */
class Cli_DbController extends Zend_Controller_Action
{

	/**
	 * sets up the layout environment;
	 */
    public function init()
    {
        
    }

    
    public function listAction()
    {

		$mapper = Db_Host::staticGetMapper();
    	$hostList = $mapper->getAll();

    	$this->view->assign("hosts", $hostList);
    }
    
    public function detailsAction(){
    	$id= $this->getRequest()->getParam("id");
    	
    	$mapper = Db_Host::staticGetMapper();
    	$host = $mapper->getById($id);
    	print_r($host);die();
    	if (count($host)){
    		$this->view->assign("host", $host[0]);
    	}
    }
    
    public function tablesAction(){
    	$hostDA = HostDA::getInstance();
    	
    	$hostID = $this->getRequest()->getParam("host");
    	$hostList = $hostDA->filter(array(array("field"=>"unique_name", "value"=>$hostID)), array("field" => "name"));
    	Connection_Manager::initFromList($hostList);
    	
    	$connection = Connection_Manager::getByName($hostID);
    	
    	$tables = Db_Reader::readTableNames($connection);
    	
    	$tmpTables = array();
    	
    	if (count($tables)){
    		foreach ($tables as $table){
    			$tmpTables[] = array("name"=>$table);
    		}
    	}
    	$this->view->assign("tables", $tmpTables);
    }
}