<?php
/**
 * Host front controller
 * 
 * @author Cristian.Moldovan <cristi@ids-team.com>
 * @package MODULES
 * @subpackage CLASS
 */
class Code_ClassController extends Zend_Controller_Action
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
//	            $this->_helper->layout->disableLayout();
//	            $ajaxContext = $this->_helper->getHelper('AjaxContext');
//	            $ajaxContext->addActionContext('list', 'html');
//	            $ajaxContext->initContext();
	   // }
        
    }

    
    public function listAction()
    {
    	
    	
    	$tableNamesJSON = $this->getRequest()->getParam("tableNames");
    	
    	$hostID = $this->getRequest()->getParam("host");
    	
    	Connection_Manager::initFromConfig(Config_Controller::getSection("instances"));
    	$hostList = Connection_Manager::getAllConnectionsDefinitions();
    	 
    	Connection_Manager::initFromList($hostList);
    	 
    	$connection = Connection_Manager::getByID($hostID);
    	
    	try{
    		$tables = Zend_Json::decode(stripslashes($tableNamesJSON));
    	}
    	catch(Exception $ex){
    		$tables = Db_Reader::readTableNames($connection);	
    	}
    	
    	$classes = array();
    	
    	if (count($tables)){
    		foreach ($tables as $table){
    			$className = Code_Util::getClassNameFromDbTableName($table);
    			$classes[] = array(
    				"name"=>$className,
    				"path"=>Code_Util::getPathFromClassName($className).Code_Util::getFileNameFromClassName($className).".php",
    				"table" =>$table
    			);
    		}
    	}
    	$this->view->assign("classes", $classes);
    }
}