<?php

echo "
<?php

/**
* ".$class->getComments()."
*
* @author ".$class->getAuthor()."
* @package ".$class->getPackage()."
* @subpackage ".$class->getSubpackage()."
* @version ".$class->getVersion()."
* @date: ".$class->getDate();
if ($class->hasRelations()){
	foreach ($class->getRelations() as $relation){
		echo "\n* @uses ".$relation->getTargetClass();
	}
}
echo "
*/

class ".$class->getName().""; if (! is_null($class->getSuperclass())) echo " extends ".$class->getSuperclass(); echo " {

	";
		if (count($class->getAttributes())){
			foreach($class->getAttributes() as $attribute){
	echo "
	
	/**
	 * ".$attribute->getComments()."
	 * @var ".$attribute->getType()."
	 */
	";
	echo $attribute->getAccessLevel()." "; if ($attribute->getIsStatic()) echo "static "; echo "$".$attribute->getName().";";			
				
			}
		} 
	
		if (count($class->getConstants())){
			foreach($class->getConstants() as $constant){
	
	echo "
	/**
	 * ".$constant->getComments()."
	 * @var ".$constant->getType()."
	 */
	const ".$constant->getName()." = '".$constant->getValue()."';
	";
				
				
			}
		} 
?>
		
		private static function loadClasesInFolder($path){
			if (! is_dir($path)) return;
		 
			if ($handle = opendir($path)) {
			    while (false !== ($file = readdir($handle))) {
			    	if ($file != "." && $file != ".." && $file != ".DS_STORE" && $file !=".svn") {
				    	if (! is_dir($path.DIRECTORY_SEPARATOR.$file)) {
					        try{
					        	Zend_Loader::loadFile($path.DIRECTORY_SEPARATOR.$file, "", true);
					        }
					        catch (Exception $ex){
					        	Logger::write($ex->getMessage());
					        }
				    	}else{
				    		self::loadClasesInFolder($path.DIRECTORY_SEPARATOR.$file);
				    	}
			    	}
			    }
			    closedir($handle);
			}
		}
		
		public static function initEnvironment(){
			
			Zend_Loader::loadClass("Config_Controller");
			Zend_Loader::loadClass("Logger");
			Zend_Loader::loadClass("DA_Abstract");
			Zend_Loader::loadClass("Session");
			Zend_Loader::loadClass("Auth");
			Zend_Loader::loadClass("Messages");
			Zend_Loader::loadClass("Utils_Date");
			Zend_Loader::loadClass("Utils_Path");
			Zend_Loader::loadClass("Utils_Image");
			Zend_Loader::loadClass("Utils_Url");
			Zend_Loader::loadClass("Utils_Validate");
			
			// load core components
			
			
			
			
			
			Zend_Loader::loadClass("ZendAmfServiceBrowser");
			
			//require_once APPLICATION_PATH.DIRECTORY_SEPARATOR."da".DIRECTORY_SEPARATOR."UsersDA.php";
			
			
		}
		protected function _initView(){
	        // Initialize view
	        $this->initApp();
	       	return $this->initView();
	    }

	   
	    
		public function setupRoutes(Zend_Controller_Front $frontController){
			// Retrieve the router from the frontcontroller
			$router = $frontController->getRouter();
			
			$router->addRoute(
				'default',
				new Zend_Controller_Router_Route('/*', array(
						'module'	=> 'preview',
						'controller'=> 'index',
						'action'     => 'index'
					)
				)
			);		
			return $router;
		}
		
		/**
		 * Initializes the main app objects.
		 * 
		 * It includes the requeried files and sets up default values for the app to run
		 */
		public function initApp(){
			
			Config_Controller::setSection("main", $this->getApplication()->getOptions());
			define("BASE_PATH", Config_Controller::getValueFromSection("main", "base_path"));
			define("BASE_URL", Config_Controller::getValueFromSection("main", "base_url"));
			
			$this->readConfigs();
			
			$paths = $this->getApplication()->getOption("includePaths");
			$baseLibrary = $paths["library"];
			
			Zend_Loader::loadFile($baseLibrary.DIRECTORY_SEPARATOR."Smarty".DIRECTORY_SEPARATOR."Smarty.class.php");
			unset($paths["library"]);
			if (count($paths)){
				foreach ($paths as $path){
					ob_start();
					self::loadClasesInFolder($path);
					ob_end_clean();		
				}
			}
			
			Code_Generator::setGeneratorConfig(Config_Controller::getSection("smarty"));
		}
		
		/**
		 * Inits the view environment and sets up JS and CSS paths
		 */
		private function initView(){
			Zend_Controller_Action_HelperBroker::addPath(
        	APPLICATION_PATH .'/modules/default/views/helpers');
			$view = new Zend_View();
	        
			$view->addHelperPath(APPLICATION_PATH .'/modules/default/views/helpers');
			$view->addScriptPath(APPLICATION_PATH .'/modules/default/views/scripts');
			 
	        $view->doctype('XHTML1_STRICT');
	        
	        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html; charset=UTF-8')
                 			 ->appendHttpEquiv('Content-Language', 'en-US');
	        $view->headTitle('ORM');

	        
//			
	        
	       
	        
	        // Add it to the ViewRenderer
	        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper(
	            'ViewRenderer'
	        );
	        $viewRenderer->setView($view);
	        
	        $options = array(
			  'layoutPath' => APPLICATION_PATH.'/layouts',
			  'layout' => 'main',
	          ''
			);
			$layout = Zend_Layout::startMVC($options); 
	        
	        $frontController = Zend_Controller_Front::getInstance();
	    	$frontController->setParam('useModules', true);
	        $frontController->addModuleDirectory(APPLICATION_PATH.'/modules');
	        $frontController->throwExceptions(true);
	        
	     
	        return $view;
		}
		
		/**
		 * reads application additional config files from /app/config folder
		 */
		private function readConfigs(){
			$cfgFolder = APPLICATION_PATH.DIRECTORY_SEPARATOR."config";
			
			if ($handle = opendir($cfgFolder)) {
			    while (false !== ($file = readdir($handle))) {
			        if ($file != "." && $file != ".." && $file != ".DS_STORE" && $file != "application.ini" && $file !=".svn") {
			        	try{
			        		$config = new Zend_Config_Ini($cfgFolder.DIRECTORY_SEPARATOR.$file, APPLICATION_ENV);
			        		Config_Controller::setSection(str_replace(".ini", "", $file), $config->toArray());
			        	}
			        	catch (Exception $ex){
			        		Logger::write($ex->getMessage());
			        	}
			        }
			    }
			    closedir($handle);
			}
			
		}
		
		
}

?>