<?php
// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH',
              realpath(dirname(__FILE__) . DIRECTORY_SEPARATOR.'app'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV',
              (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV')
                                         : 'production'));

// Typically, you will also want to add your library/ directory
// to the include_path, particularly if it contains your ZF installed
set_include_path(implode(PATH_SEPARATOR, array(
    APPLICATION_PATH .'/../../../common/library',
    get_include_path()
)));

/** Zend_Application */
require_once 'Zend/Application.php';

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
try{
$application->bootstrap()
            ->run();
}
catch (Exception $ex){
	Logger::write($ex->getMessage());
}
   
?>
