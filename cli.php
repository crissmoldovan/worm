<?php
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors',true);
// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH',
              realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR.'app'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV',
              (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV')
                                         : 'development'));

// Typically, you will also want to add your library/ directory
// to the include_path, particularly if it contains your ZF installed
set_include_path(implode(PATH_SEPARATOR, array(
    dirname(__FILE__) . DIRECTORY_SEPARATOR.'library',
    get_include_path()
)));

/** Zend_Application */
require_once 'Zend/Application.php';
require_once('Zend/Loader.php');



// Create application, bootstrap, and run

$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'application.ini'
);


$auxLib = $application->getOption("includePaths");

set_include_path(implode(PATH_SEPARATOR, array(
    $auxLib["auxLibrary"],
    $auxLib["modelsLibrary"],
    $auxLib["coreLibrary"],
    $auxLib["amfLibrary"],
    get_include_path()
)));

Bootstrap::initEnvironment();


$application->getBootstrap()->initApp();
try {
    $opts = new Zend_Console_Getopt(
        array(
            'help|h' => 'Displays usage information.',
            'action|a=s' => 'Action to perform in format of module.controller.action',
            'verbose|v' => 'Verbose messages will be dumped to the default output.',
            'development|d' => 'Enables development mode.',
        )
    );
    $opts->parse();
} catch (Zend_Console_Getopt_Exception $e) {
    exit($e->getMessage() ."\n\n". $e->getUsageMessage());
}
 
if(isset($opts->h)) {
    echo $opts->getUsageMessage();
    exit;
}

if(isset($opts->a)) {
    $reqRoute = array_reverse(explode('.',$opts->a));
    @list($action,$controller,$module) = $reqRoute;
    
    $params = $opts->getRemainingArgs();
    $paramsIndexed = array();
    if (is_array($params)){
    	foreach ($params as $param){
    		$paramPieces = explode("=", $param);
    		$paramsIndexed[$paramPieces[0]] = $paramPieces[1];
    	}
    }
    
    $request = new Zend_Controller_Request_Simple($action,$controller,$module, $paramsIndexed);
    $front = Zend_Controller_Front::getInstance();
 
    $front->setRequest($request);
    $front->setRouter(new Controller_Router_Cli());
 
    $front->setResponse(new Zend_Controller_Response_Cli());
 
    $front->throwExceptions(true);
    $front->addModuleDirectory(APPLICATION_PATH . DIRECTORY_SEPARATOR. 'modules/');
 
    $front->dispatch();
}
