<?php
/**
 * Host front controller
 * 
 * @author Cristian.Moldovan <cristi@ids-team.com>
 * @package MODULES
 * @subpackage HOST
 */
class Cli_AppController extends Zend_Controller_Action
{

	/**
	 * sets up the layout environment;
	 */
    public function init()
    {
        
    }
    
    public function infoAction(){
    	$app = new App(App_Info::staticGetMapper()->getById($this->getRequest()->getParam("id")));
    	
    	print_r($app->getAllPaths());
    	
    	die();
    }
}