<?php
/**
 * @TODO DOCUMENT
 */ 
class App{
	/**
	 * 
	 * holds the basic info about the app  / persisted
	 * @var App_Info
	 */
	private $_appInfo = null;
	
	/**
	 * 
	 * inits the app object
	 * @param App_Info $info
	 * @throws Exception
	 */
	public function __construct(App_Info $info){
		$this->_appInfo = $info;
	}
	
	/**
	 * 
	 * Gets the Application's name
	 * @return string
	 */
	public function getName(){
		return $this->_appInfo->getName();
	}
	
	/**
	 * 
	 * Gets the Application's short name
	 * @return string
	 */
	public function getShortName(){
		return $this->_appInfo->getAppShortName();
	}
	
	/**
	 * @return string $_basePath
	 */
	public function getBasePath() {
		$path = $this->_appInfo->getBasePath();
		$lastChr = substr($path, (strlen($path)-1), 1);
		if ($lastChr == DIRECTORY_SEPARATOR) return $path;
		else return $path.DIRECTORY_SEPARATOR;
	}

	/**
	 * @return the $_appFolder
	 */
	public function getAppFolder() {
		return $this->_appInfo->getAppFolder();
	}
	
	/**
	 * 
	 * Gets the path to Application folder
	 * @return string
	 */
	public function getAppPath(){
		return $this->getBasePath().$this->getAppFolder().DIRECTORY_SEPARATOR;
	}

	/**
	 * @return the $_publicFolder
	 */
	public function getPublicFolder() {
		return $this->_appInfo->getPublicFolder();
	}
	
	/**
	 * 
	 * Gets the path to public folder
	 * @return string
	 */
	public function getPublicPath(){
		return $this->getBasePath().$this->getPublicFolder().DIRECTORY_SEPARATOR;
	}

	/**
	 * @return the $_configFolder
	 */
	public function getConfigFolder() {
		return $this->_appInfo->getConfigFolder();
	}

	/**
	 * 
	 * Gets the path to config folder
	 * @return string
	 */
	public function getConfigPath(){
		return $this->getBasePath().$this->getConfigFolder().DIRECTORY_SEPARATOR;
	}
	/**
	 * @return the $_modelsFolder
	 */
	public function getModelsFolder() {
		return $this->_appInfo->getModelsFolder();
	}
	
	/**
	 * 
	 * Gets the path to models folder
	 * @return string
	 */
	public function getModelsPath(){
		return $this->getBasePath().$this->getModelsFolder().DIRECTORY_SEPARATOR;
	}

	/**
	 * @return the $_modulesFolder
	 */
	public function getModulesFolder() {
		return $this->_appInfo->getModulesFolder();
	}

	/**
	 * 
	 * Gets the path to madules folder
	 * @return string
	 */
	public function getModulesPath(){
		return $this->getBasePath().$this->getModulesFolder().DIRECTORY_SEPARATOR;
	}
	/**
	 * @return the $_libraryFolder
	 */
	public function getLibraryFolder() {
		return $this->_appInfo->getLibraryFolder();
	}
	
	/**
	 * 
	 * Gets the path to Library folder
	 * @return string
	 */
	public function getLibraryPath(){
		return $this->getBasePath().$this->getLibraryFolder().DIRECTORY_SEPARATOR;
	}

	/**
	 * @return the $_defaultControllersFolder
	 */
	public function getDefaultControllersFolder() {
		return $this->_appInfo->getDefaultControllersFolder();
	}

	/**
	 * 
	 * Gets the path to Default Controller folder
	 * @return string
	 */
	public function getDefaultControllerPath(){
		return $this->getBasePath().$this->getDefaultControllersFolder().DIRECTORY_SEPARATOR;
	}
	/**
	 * @return the $_defaultViewsFolder
	 */
	public function getDefaultViewsFolder() {
		return $this->_appInfo->getDefaultViewsFolder();
	}

/**
	 * 
	 * Gets the path to DefaultVIew folder
	 * @return string
	 */
	public function getDefaultViewPath(){
		return $this->getBasePath().$this->getDefaultViewsFolder().DIRECTORY_SEPARATOR;
	}
	/**
	 * @param string $_basePath
	 */
	public function setBasePath($_basePath) {
		$this->_appInfo->setBasePath($_basePath);
	}

	/**
	 * @param string $_appFolder
	 */
	public function setAppFolder($_appFolder) {
		$this->_appInfo->setAppFolder($_appFolder);
	}

	/**
	 * @param string $_publicFolder
	 */
	public function setPublicFolder($_publicFolder) {
		$this->_appInfo->setPublicFolder($_publicFolder);
	}

	/**
	 * @param string $_configFolder
	 */
	public function setConfigFolder($_configFolder) {
		$this->_appInfo->setConfigFolder($_configFolder);
	}

	/**
	 * @param string $_modelsFolder
	 */
	public function setModelsFolder($_modelsFolder) {
		$this->_appInfo->setModelsFolder($_modelsFolder);
	}

	/**
	 * @param string $_modulesFolder
	 */
	public function setModulesFolder($_modulesFolder) {
		$this->_appInfo->setModulesFolder($_modulesFolder);
	}

	/**
	 * @param string $_libraryFolder
	 */
	public function setLibraryFolder($_libraryFolder) {
		$this->_appInfo->setLibraryFolder($_libraryFolder);
	}

	/**
	 * @param string $_defaultControllersFolder
	 */
	public function setDefaultControllersFolder($_defaultControllersFolder) {
		$this->_appInfo->setDefaultControllersFolder($_defaultControllersFolder);
	}

	/**
	 * @param string $_defaultViewsFolder
	 */
	public function setDefaultViewsFolder($_defaultViewsFolder) {
		$this->_appInfo->setDefaultViewsFolder($_defaultViewsFolder);
	}
 
	/**
	 * 
	 * Gets all paths as assoc. array
	 * @return array
	 */
	public function getAllPaths(){
		return array(
			"base" 		=> $this->getBasePath(),
			"app"		=> $this->getAppPath(),
			"config" 	=> $this->getConfigPath(),
			"models" 	=> $this->getModelsPath(),
			"modules" 	=> $this->getModulesPath(),
			"library" 	=> $this->getLibraryPath(),
			"default_controller" 	=> $this->getDefaultControllerPath(),
			"default_views" 		=> $this->getDefaultViewPath()
		);
	}
	
	
	
}