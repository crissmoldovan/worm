<?php
/**
 * Host front controller
 * 
 * @author Cristian.Moldovan <cristi@ids-team.com>
 * @package MODULES
 * @subpackage HOST
 */
class Db_HostController extends Zend_Controller_Action
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
	            $ajaxContext->addActionContext('details', 'html');
	            $ajaxContext->initContext();
	   // }
        
    }

    
    public function listAction()
    {
    	Connection_Manager::initFromConfig(Config_Controller::getSection("instances"));
    	$hostList = Connection_Manager::getAllConnectionsDefinitions();
    	$this->view->assign("hosts", $hostList);
    }
    
    public function detailsAction(){
    	$id= $this->getRequest()->getParam("id");
    	
    	$hostDA = HostDA::getInstance();
    	$host = $hostDA->filter(array(array("field"=>"id", "value"=>$id)));
    	if (count($host)){
    		$this->view->assign("host", $host[0]);
    	}
    }
}