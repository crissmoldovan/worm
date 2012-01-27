<?php
/**
 * Host front controller
 * 
 * @author Cristian.Moldovan <cristi@ids-team.com>
 * @package MODULES
 * @subpackage TABLE
 */
class Db_TableController extends Zend_Controller_Action
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
    	$hostDA = HostDA::getInstance();
    	
    	$hostID = $this->getRequest()->getParam("host");
    	
    	Connection_Manager::initFromConfig(Config_Controller::getSection("instances"));
    	$hostList = Connection_Manager::getAllConnectionsDefinitions();
    	
    	Connection_Manager::initFromList($hostList);
    	
    	$connection = Connection_Manager::getByID($hostID);
    	
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