
<?php

/**
* 
*
* @author Techlark ORM <orm@techlark.com>
* @package models
* @subpackage 
* @version 1
* @date: 2011-10-20
*/

class App_Info {

	
	
	/**
	 * 
	 * @var integer
	 */
	private $id;
	
	/**
	 * 
	 * @var string
	 */
	private $name;
	
	/**
	 * 
	 * @var string
	 */
	private $app_short_name;
	
	/**
	 * 
	 * @var string
	 */
	private $base_path;
	
	/**
	 * 
	 * @var string
	 */
	private $app_folder;
	
	/**
	 * 
	 * @var string
	 */
	private $config_folder;
	
	/**
	 * 
	 * @var string
	 */
	private $models_folder;
	
	/**
	 * 
	 * @var string
	 */
	private $modules_folder;
	
	/**
	 * 
	 * @var string
	 */
	private $library_folder;
	
	/**
	 * 
	 * @var string
	 */
	private $public_folder;
	
	/**
	 * 
	 * @var string
	 */
	private $default_controllers_folder;
	
	/**
	 * 
	 * @var string
	 */
	private $default_views_folder;
	
	/**
	 * 
	 * @var 
	 */
	private $repo_type;
	
	/**
	 * 
	 * @var string
	 */
	private $repo_url;
	
	/**
	 * 
	 * @var string
	 */
	private $repo_user;
	
	/**
	 * 
	 * @var string
	 */
	private $repo_pass;
	
	/**
	 * 
	 * @var 
	 */
	private $repo_enabled;
	
	/**
	 * 
	 * @var integer
	 */
	private $db_host_id;
	/**
	 * 
	 * @var string
	 */
	const repo_type_SVN = 'SVN';
	
	/**
	 * 
	 * @var string
	 */
	const repo_type_GIT = 'GIT';
	
	/**
	 * 
	 * @var string
	 */
	const repo_type_HG = 'HG';
	
	/**
	 * 
	 * @var string
	 */
	const repo_type_DEFAULT = 'SVN';
	
	/**
	 * 
	 * @var string
	 */
	const repo_enabled_YES = 'YES';
	
	/**
	 * 
	 * @var string
	 */
	const repo_enabled_NO = 'NO';
	
	/**
	 * 
	 * @var string
	 */
	const repo_enabled_DEFAULT = 'NO';
	
	/**
	 * 
	 * @var string
	 */
	const table_name = 'app_info';
		
	/**
	* Converts the current object to an array and string some properties if param $exclude is true
	* 
	* @param boolean $exclude
	*/
	public function toArray($exclude = true){
		$result = array();
		foreach($this as $key => $value){
			if($exclude){
				if ($key!="id"){
					$result[$key] = $value;
				}
			}else{
				$result[$key] = $value;
			}
		}
			
		return $result;
	}

	/**
	 * Sets the current object's properties from a given array (usually a result of an db query)
	 * 
	 * @param array $rs
	 */
	public function setFromRS($rs = null){
		if (! is_null($rs)){
			foreach($this as $key => $value){
				if (! is_null($rs[$key])) $this->$key = $rs[$key];
			}
		}
	}
	
	/**
	* @return App_Info_Mapper
	*/
	public function getMapper(){
		return App_Info::staticGetMapper();
	}
	
	/**
	* @return App_Info_Mapper
	*/
	public static function staticGetMapper(){
		return App_Info_Mapper::getInstance();
	} 
	
	public function save(){
		$mapper = $this->getMapper();
		if ($this->id == null){
			$this->id = $mapper->insert($this->toArray());
		}else{
			$mapper->update($this->toArray(), $this->id);
		}
	}
	
	/**
	 *  gets the id attribute	 * 
	 * @param integer $id
	 * @return integer
	 */
	public  function getId($id = ''){
		return $this->id;
	}

	/**
	 *  gets the name attribute	 * 
	 * @param string $name
	 * @return string
	 */
	public  function getName($name = ''){
		return $this->name;
	}

	/**
	 *  gets the app_short_name attribute	 * 
	 * @param string $app_short_name
	 * @return string
	 */
	public  function getAppShortName($app_short_name = ''){
		return $this->app_short_name;
	}

	/**
	 *  gets the base_path attribute	 * 
	 * @param string $base_path
	 * @return string
	 */
	public  function getBasePath($base_path = ''){
		return $this->base_path;
	}

	/**
	 *  gets the app_folder attribute	 * 
	 * @param string $app_folder
	 * @return string
	 */
	public  function getAppFolder($app_folder = ''){
		return $this->app_folder;
	}

	/**
	 *  gets the config_folder attribute	 * 
	 * @param string $config_folder
	 * @return string
	 */
	public  function getConfigFolder($config_folder = ''){
		return $this->config_folder;
	}

	/**
	 *  gets the models_folder attribute	 * 
	 * @param string $models_folder
	 * @return string
	 */
	public  function getModelsFolder($models_folder = ''){
		return $this->models_folder;
	}

	/**
	 *  gets the modules_folder attribute	 * 
	 * @param string $modules_folder
	 * @return string
	 */
	public  function getModulesFolder($modules_folder = ''){
		return $this->modules_folder;
	}

	/**
	 *  gets the library_folder attribute	 * 
	 * @param string $library_folder
	 * @return string
	 */
	public  function getLibraryFolder($library_folder = ''){
		return $this->library_folder;
	}

	/**
	 *  gets the public_folder attribute	 * 
	 * @param string $public_folder
	 * @return string
	 */
	public  function getPublicFolder($public_folder = ''){
		return $this->public_folder;
	}

	/**
	 *  gets the default_controllers_folder attribute	 * 
	 * @param string $default_controllers_folder
	 * @return string
	 */
	public  function getDefaultControllersFolder($default_controllers_folder = ''){
		return $this->default_controllers_folder;
	}

	/**
	 *  gets the default_views_folder attribute	 * 
	 * @param string $default_views_folder
	 * @return string
	 */
	public  function getDefaultViewsFolder($default_views_folder = ''){
		return $this->default_views_folder;
	}

	/**
	 *  gets the repo_type attribute	 * 
	 * @param  $repo_type
	 * @return 
	 */
	public  function getRepoType( $repo_type = ''){
		return $this->repo_type;
	}

	/**
	 *  gets the repo_url attribute	 * 
	 * @param string $repo_url
	 * @return string
	 */
	public  function getRepoUrl($repo_url = ''){
		return $this->repo_url;
	}

	/**
	 *  gets the repo_user attribute	 * 
	 * @param string $repo_user
	 * @return string
	 */
	public  function getRepoUser($repo_user = ''){
		return $this->repo_user;
	}

	/**
	 *  gets the repo_pass attribute	 * 
	 * @param string $repo_pass
	 * @return string
	 */
	public  function getRepoPass($repo_pass = ''){
		return $this->repo_pass;
	}

	/**
	 *  gets the repo_enabled attribute	 * 
	 * @param  $repo_enabled
	 * @return 
	 */
	public  function getRepoEnabled( $repo_enabled = ''){
		return $this->repo_enabled;
	}

	/**
	 *  gets the db_host_id attribute	 * 
	 * @param integer $db_host_id
	 * @return integer
	 */
	public  function getDbHostId($db_host_id = ''){
		return $this->db_host_id;
	}

	/**
	 *  sets the id attribute	 * 
	 * @param integer $id
	 * @return integer
	 */
	public  function setId($id = ''){
		$this->id = $id;
	}

	/**
	 *  sets the name attribute	 * 
	 * @param string $name
	 * @return string
	 */
	public  function setName($name = ''){
		$this->name = $name;
	}

	/**
	 *  sets the app_short_name attribute	 * 
	 * @param string $app_short_name
	 * @return string
	 */
	public  function setAppShortName($app_short_name = ''){
		$this->app_short_name = $app_short_name;
	}

	/**
	 *  sets the base_path attribute	 * 
	 * @param string $base_path
	 * @return string
	 */
	public  function setBasePath($base_path = ''){
		$this->base_path = $base_path;
	}

	/**
	 *  sets the app_folder attribute	 * 
	 * @param string $app_folder
	 * @return string
	 */
	public  function setAppFolder($app_folder = ''){
		$this->app_folder = $app_folder;
	}

	/**
	 *  sets the config_folder attribute	 * 
	 * @param string $config_folder
	 * @return string
	 */
	public  function setConfigFolder($config_folder = ''){
		$this->config_folder = $config_folder;
	}

	/**
	 *  sets the models_folder attribute	 * 
	 * @param string $models_folder
	 * @return string
	 */
	public  function setModelsFolder($models_folder = ''){
		$this->models_folder = $models_folder;
	}

	/**
	 *  sets the modules_folder attribute	 * 
	 * @param string $modules_folder
	 * @return string
	 */
	public  function setModulesFolder($modules_folder = ''){
		$this->modules_folder = $modules_folder;
	}

	/**
	 *  sets the library_folder attribute	 * 
	 * @param string $library_folder
	 * @return string
	 */
	public  function setLibraryFolder($library_folder = ''){
		$this->library_folder = $library_folder;
	}

	/**
	 *  sets the public_folder attribute	 * 
	 * @param string $public_folder
	 * @return string
	 */
	public  function setPublicFolder($public_folder = ''){
		$this->public_folder = $public_folder;
	}

	/**
	 *  sets the default_controllers_folder attribute	 * 
	 * @param string $default_controllers_folder
	 * @return string
	 */
	public  function setDefaultControllersFolder($default_controllers_folder = ''){
		$this->default_controllers_folder = $default_controllers_folder;
	}

	/**
	 *  sets the default_views_folder attribute	 * 
	 * @param string $default_views_folder
	 * @return string
	 */
	public  function setDefaultViewsFolder($default_views_folder = ''){
		$this->default_views_folder = $default_views_folder;
	}

	/**
	 *  sets the repo_type attribute	 * 
	 * @param  $repo_type
	 * @return 
	 */
	public  function setRepoType( $repo_type = ''){
		$this->repo_type = $repo_type;
	}

	/**
	 *  sets the repo_url attribute	 * 
	 * @param string $repo_url
	 * @return string
	 */
	public  function setRepoUrl($repo_url = ''){
		$this->repo_url = $repo_url;
	}

	/**
	 *  sets the repo_user attribute	 * 
	 * @param string $repo_user
	 * @return string
	 */
	public  function setRepoUser($repo_user = ''){
		$this->repo_user = $repo_user;
	}

	/**
	 *  sets the repo_pass attribute	 * 
	 * @param string $repo_pass
	 * @return string
	 */
	public  function setRepoPass($repo_pass = ''){
		$this->repo_pass = $repo_pass;
	}

	/**
	 *  sets the repo_enabled attribute	 * 
	 * @param  $repo_enabled
	 * @return 
	 */
	public  function setRepoEnabled( $repo_enabled = ''){
		$this->repo_enabled = $repo_enabled;
	}

	/**
	 *  sets the db_host_id attribute	 * 
	 * @param integer $db_host_id
	 * @return integer
	 */
	public  function setDbHostId($db_host_id = ''){
		$this->db_host_id = $db_host_id;
	}

}

?>