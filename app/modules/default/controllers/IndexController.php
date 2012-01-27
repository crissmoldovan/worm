<?php
/**
 * Top level front controller
 * 
 * @author Cristian.Moldovan <cristi@ids-team.com>
 * @package MODULES
 * @subpackage AMF
 * @todo define actions
 */
class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        Zend_Layout::getMvcInstance()->setLayout('ext');
    }

    public function testAction(){
    	$startTime = microtime(true);
    	$hostDA = HostDA::getInstance();
    	$hostList = $hostDA->filter(array(), array("field" => "name"));
    	
    	Connection_Manager::initFromConfig(Config_Controller::getSection("instances"));
    	
    	$connectionName = "saylocal_local";
    	
    	$tables = Core_DatabaseStructureManager::getAvailableTablesForConection($connectionName);
    	
    	if (count($tables)){
    		foreach ($tables as $table){
    			$dbTable = Core_DatabaseStructureManager::readTableStructure($connectionName, $table);
    			$class = Db_Mapper_TableToClass::map($dbTable);
    			Code_Generator::generateCode($class);
    		}
    	}
    	
    	//$folder = Code_Util::getPathFromClassName($class->getName());
    	//$file = Code_Util::getFileNameFromClassName($class->getName());
    	
    	
    	
    	$endTime = microtime(true);
    	
    	$duration = $endTime - $startTime;
    	
    	echo " took {$duration} sec. to load all table structures<br/>"; 
    	echo " memory used: ".$this->MBFormat(memory_get_usage($true), 4)." MB";
    	
    	Code_Generator::generateCode();
    }
    public function indexAction()
    {
//    	
    	
    }
    
    function MBFormat($bytes,$decimals=1)
	{
	    return number_format($bytes/(1024*1024),$decimals);
	} 

}

