<?php
/**
 * Host front controller
 * 
 * @author Cristian.Moldovan <cristi@ids-team.com>
 * @package MODULES
 * @subpackage CLASS
 */
class Code_IndexController extends Zend_Controller_Action
{

	/**
	 * sets up the layout environment;
	 */
    public function init()
    {
    	Zend_Layout::getMvcInstance()->setLayout('amf');
		$contextSwitch = $this->_helper->getHelper('contextSwitch');
		$contextSwitch->addActionContext('list', array('xml','json'))->initContext();
		
	  //  if ($this->getRequest()->isXmlHttpRequest()) {
	            $this->_helper->layout->disableLayout();
	            $ajaxContext = $this->_helper->getHelper('AjaxContext');
	            $ajaxContext->addActionContext('index', 'html');
	            $ajaxContext->addActionContext('generate', 'html');
	            $ajaxContext->addActionContext('preview', 'html');
	            $ajaxContext->initContext();
	   // }
        
    }

    
    public function indexAction()
    {
    	$hostID = $this->getRequest()->getParam("host");
    	$uniqueID = uniqid();
    	$outputPath = Config_Controller::getValueFromSection("orm", "outputFolder").DIRECTORY_SEPARATOR.$uniqueID;
    	$modelsPath = $outputPath.DIRECTORY_SEPARATOR."models";
    	$daPath = $outputPath.DIRECTORY_SEPARATOR."da";
    	$managersPath = $outputPath.DIRECTORY_SEPARATOR."managers";
    	$this->view->assign("outputPath", Config_Controller::getValueFromSection("orm", "outputFolder"));
    	$this->view->assign("host", $hostID);
    	$this->view->assign("uniqueID", $uniqueID);
    	$this->view->assign("modelsPath", $modelsPath);
    	$this->view->assign("daPath", $daPath);
    	$this->view->assign("managersPath", $managersPath);
    }
    
    public function generateAction(){
    	
	    	
	    	$output = $this->getRequest()->getParam("output");
	    	
	    	$hostID = $this->getRequest()->getParam("host");
	    	
	    	$messageQueue = array();
	    	try{
	    		$startTime = microtime(true);
	    		$output = $this->getRequest()->getParam("output");
	    		$connectionName = $this->getRequest()->getParam("host");
	    	
	    		if (! is_writable($output)) throw new Exception("Output path does not exist or is not writable!");
	    		 
	    		if (! strstr($output, "models")) $modelsPath = $output.DIRECTORY_SEPARATOR."models";
	    		else $modelsPath = $output;
	    		if (!file_exists($modelsPath)) @mkdir($modelsPath, 0777);
	    			
	    		Connection_Manager::initFromConfig(Config_Controller::getSection("instances"));
	    		$hostList = Connection_Manager::getAllConnectionsDefinitions();
	    		 
	    		Connection_Manager::initFromList($hostList);
	    		 
	    		$connection = Connection_Manager::getByID($hostID);
	    	
	    	
	    		$messageQueue[] = array("msg"=>"<hr />Generating Models to <i>{$modelsPath}</i>", "status" => "");
	    		$tableNames = $this->getRequest()->getParam("tables");
	    	
	    		if ($tableNames == "all"){
	    			$tables = Core_DatabaseStructureManager::getAvailableTablesForConection($connectionName);
	    		}else{
	    			$tables = Zend_Json::decode(stripcslashes($this->getRequest()->getParam("tableNames")));
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
	    		if ($tableNames == "all"){
	    			$tables = Core_DatabaseStructureManager::getAvailableTablesForConection($connectionName);
	    		}else{
	    			$tables = Zend_Json::decode(stripcslashes($this->getRequest()->getParam("tableNames")));
	    		}
	    		 
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
	
	public function previewAction(){
		$table = $this->getRequest()->getParam("table");
		$type = $this->getRequest()->getParam("type");
		
		$messageQueue = array();
    	try{

	    	$hostID = $this->getRequest()->getParam("host");
			
	    	Connection_Manager::initFromConfig(Config_Controller::getSection("instances"));
	    	$hostList = Connection_Manager::getAllConnectionsDefinitions();
	    	 
	    	Connection_Manager::initFromList($hostList);
	    	 
	    	$connection = Connection_Manager::getByID($hostID);
	    	
	    	$connectionName = $hostList[0]["unique_name"];
		    	
	    	switch($type){
	    		case 'model':
			    	try{
						$dbTable = Core_DatabaseStructureManager::readTableStructure($connectionName, $table);
						$class = Db_Mapper_TableToClass::map($dbTable);
						$code = Code_Generator::previewCode($class);
					}
					catch (Exception $ex){
						$messageQueue[] = array("msg"=>"processing table <b>".$table."</b>", "status" => "failed");
					}
		    	break;
	    		case 'da':
				    try{
						$dbTable = Core_DatabaseStructureManager::readTableStructure($connectionName, $table);
						$class = Db_Mapper_TableToDA::map($dbTable);
					    			
						$code = Code_Generator::previewCode($class);
				   	}
				    catch (Exception $ex){
				    	$messageQueue[] = array("msg"=>"processing table <b>".$table."</b>", "status" => "failed");
				    }
				break;
				case 'mapper':
				    try{
						$dbTable = Core_DatabaseStructureManager::readTableStructure($connectionName, $table);
						$class = Db_Mapper_TableToMapper::map($dbTable);
					    			
						$code = Code_Generator::previewCode($class);
				   	}
				    catch (Exception $ex){
				    	$messageQueue[] = array("msg"=>"processing table <b>".$table."</b>", "status" => "failed");
				    }
				break;
	    	}
	    }
	    catch (Exception $ex){
	    	$messageQueue[] = array("msg"=>"ERROR OCCURED: ".$ex->getMessage(), "status" => "");
	    }
	    
	    $this->view->assign("code", $code);
	    $this->view->assign("type", $type);
	}
	
	public function testAction(){
		$command = " cd /Users/criss/htdocs/saylocal; svn status";
		$output = explode("\n", shell_exec($command));
		echo "<pre>";
		print_r($output);
		echo "</pre>";
		die();
	}
}