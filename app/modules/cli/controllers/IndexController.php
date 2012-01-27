<?php
/**
 * Top level front controller
 * 
 * @author Cristian.Moldovan <cristi@ids-team.com>
 * @package MODULES
 * @subpackage AMF
 * @todo define actions
 */
class Cli_IndexController extends Zend_Controller_Action
{

    public function init()
    {
                
    }

    public function indexAction()
    {
     echo "default cli\n";	

     die();
    }
}

