<?php
/**
 * Host front controller
 * 
 * @author Cristian.Moldovan <cristi@ids-team.com>
 * @package MODULES
 * @subpackage HOST
 */
class Cli_GenController extends Zend_Controller_Action
{

	/**
	 * sets up the layout environment;
	 */
    public function init()
    {
        
    }

    public function previewAction(){
    	$table = $this->getRequest()->getParam("table");
		$type = $this->getRequest()->getParam("type");
		$output = $this->getRequest()->getParam("output");
		$messageQueue = array();
    	try{

	    	$connectionName = $this->getRequest()->getParam("host");
			
	    	$hostDA = HostDA::getInstance();
	    	
	    	$hostList = $hostDA->filter(array(array("field"=>"unique_name", "value"=>$connectionName)), array("field" => "name"));
	    	Connection_Manager::initFromList($hostList);
		    $dbTable = Core_DatabaseStructureManager::readTableStructure($connectionName, $table);
		    	
	    	switch($type){
	    		case 'model':
			    	try{
						$class = Db_Mapper_TableToClass::map($dbTable);
						
						switch (strtolower($output)){
							case 'json':
								$result = $class->toJSON();
							break;
							case 'xml':
								$result = $class->toXML();
							break;
							case 'code':
							default:
								$result = Code_Generator::previewCode($class);
							break;
						}
					}
					catch (Exception $ex){
						$messageQueue[] = array("msg"=>"processing table <b>".$table."</b>", "status" => "failed");
						print_r($ex->getMessage());
					}
		    	break;
	    		case 'da':
				    try{
						$class = Db_Mapper_TableToDA::map($dbTable);
				    	switch (strtolower($output)){
							case 'json':
								$result = $class->toJSON();
							break;
							case 'xml':
								$result = $class->toXML();
							break;
							case 'code':
							default:
								$result = Code_Generator::previewCode($class);
							break;
						}
				   	}
				    catch (Exception $ex){
				    	$messageQueue[] = array("msg"=>"processing table <b>".$table."</b>", "status" => "failed");
				    }
				break;
				case 'mapper':
				    try{
						$dbTable = Core_DatabaseStructureManager::readTableStructure($connectionName, $table);
						$class = Db_Mapper_TableToMapper::map($dbTable);
					    			
				    	switch (strtolower($output)){
							case 'json':
								$result = $class->toJSON();
							break;
							case 'xml':
								$result = $class->toXML();
							break;
							case 'code':
							default:
								$result = Code_Generator::previewCode($class);
							break;
						}
				   	}
				    catch (Exception $ex){
				    	$messageQueue[] = array("msg"=>"processing table <b>".$table."</b>", "status" => "failed");
				    }
				break;
	    	}
	    }
	    catch (Exception $ex){
//	    	$messageQueue[] = array("msg"=>"ERROR OCCURED: ".$ex->getMessage(), "status" => "");
			print_r($ex->getMessage());
	    }
	    
	    if (is_array($messageQueue) && !empty($messageQueue)) print_r($messageQueue);
	    $this->view->assign("result", $result);
	    $this->view->assign("type", $type);
    }
    
    public function generateAction(){
    	$messageQueue = array();
    	try{
	    	$startTime = microtime(true);
	    	$output = $this->getRequest()->getParam("path");
	    	$connectionName = $this->getRequest()->getParam("host");
	    	
	    	if (! is_writable($output)) throw new Exception("Output path does not exist or is not writable!");
	    		
	    	if (! strstr($output, "models")) $modelsPath = $output.DIRECTORY_SEPARATOR."models";
	    	else $modelsPath = $output;
    		if (!file_exists($modelsPath)) @mkdir($modelsPath, 0777);
			
	    	Connection_Manager::initFromConfig(Config_Controller::getSection("instances"));
    		$hostList = Connection_Manager::getAllConnectionsDefinitions();
    	
    		Connection_Manager::initFromList($hostList);
    	
    		$connection = Connection_Manager::getByID($connectionName);
	    	

    		$messageQueue[] = array("msg"=>"<hr />Generating Models to <i>{$modelsPath}</i>", "status" => "");
    		$tableNames = $this->getRequest()->getParam("tables");
    		
    		if ($tableNames == "all"){
	    		$tables = Core_DatabaseStructureManager::getAvailableTablesForConection($connectionName);	
	    	}
		    
	    	if (count($tables)){
	    		foreach ($tables as $table){
	    			try{
		    			$dbTable = Core_DatabaseStructureManager::readTableStructure($connectionName, $table);
		    			$class = Db_Mapper_TableToClass::mapAbstract($dbTable);
		    			$classPath = Code_Generator::generateCode($class, $modelsPath, true);
		    			$class = Db_Mapper_TableToClass::mapModel($dbTable);
		    			$classPath = Code_Generator::generateCode($class, $modelsPath, false);
		    			$messageQueue[] = array("msg"=>"created class <b>{$classPath}</b>", "status" => "ok");
	    			}
	    			catch (Exception $ex){
	    				$messageQueue[] = array("msg"=>"processing table <b>".$table."</b>", "status" => "failed");
	    				print_r($ex->getMessage());
	    			}
	    			
	    		}
	    	}	

	 			
	    	
	    	$messageQueue[] = array("msg"=>"<hr />Generating Mappers to <i>{$modelsPath}</i>", "status" => "");
		    $tables = Core_DatabaseStructureManager::getAvailableTablesForConection($connectionName);
		    	
		    if (count($tables)){
		    	foreach ($tables as $table){
		    		try{
			   			$dbTable = Core_DatabaseStructureManager::readTableStructure($connectionName, $table);
			   			$class = Db_Mapper_TableToMapper::mapAbstract($dbTable);
			   			try{
			   				$classPath = Code_Generator::generateCode($class, $modelsPath, true);
			   				$messageQueue[] = array("msg"=>"created class <b>{$classPath}</b>", "status" => "ok");
			   			}
			   			catch (Exception $ex){
			   				$messageQueue[] = array("msg"=>"ERROR creating class <b>{$classPath}</b>\n".$ex->getMessage(), "status" => "error");
			   			}
			   			$class = Db_Mapper_TableToMapper::mapMapper($dbTable);
			   			$classPath = Code_Generator::generateCode($class, $modelsPath, false);
			   			$messageQueue[] = array("msg"=>"created class <b>{$classPath}</b>", "status" => "ok");
		    		}
		    		catch (Exception $ex){
		    			$messageQueue[] = array("msg"=>"processing table <b>".$table."</b>", "status" => "failed");
		    			print_r($ex->getMessage());
		    		}
		    		
		    	}
		    }
    	}
    	
    	catch (Exception $ex){
    		$messageQueue[] = array("msg"=>"ERROR OCCURED: ".$ex->getMessage(), "status" => "");
    		print_r($ex->getMessage());
    		
    	}
    	
    	print_r($messageQueue);	
    	
    	
    	//$folder = Code_Util::getPathFromClassName($class->getName());
    	//$file = Code_Util::getFileNameFromClassName($class->getName());
    	
    	
    	
    	$endTime = microtime(true);
    	
    	$duration = $endTime - $startTime;
 
    	$memory = $this->MBFormat(memory_get_usage(true), 4)." MB";
    	
    	$this->view->assign("duration", $duration);
    	$this->view->assign("memory", $memory);
    	$this->view->assign("messageQueue", $messageQueue);
    }
    function MBFormat($bytes,$decimals=1)
	{
	    return number_format($bytes/(1024*1024),$decimals);
	} 
	
}