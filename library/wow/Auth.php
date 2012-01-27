<?php
/**
 * Authentification utility
 * @author Cristian.Moldovan <cristi@ids-team.com>
 * @package WOW_LIB
 * @subpackage UTILS
 * @todo FUTHER DOCS
 */
class Auth extends DA_Abstract{
	private static $instance = null;
	
	/*
	 * @return Auth
	 */
	public static function getInstance(){
		if (is_null(self::$instance)) self::$instance = new Auth(User::table_name);
		
		return self::$instance;
	}
	public function verify($actionHelper, $useHttp = true){
		$userData = Session::get("auth_user");
		if (is_null($userData)){
			if ($useHttp){
				$actionHelper->redirect(BASE_URL."/account/auth/login");
			}else{
				return false;
			}
		}
		
		return true;
	}
	
	public function validate($username, $password){
		if (is_null($this->db)) $this->initDb();
		
		$authAdapter = new Zend_Auth_Adapter_DbTable(
		    $this->db,
		    User::table_name,
		    User::email,
		    User::password,
		    'MD5(?)'
		);
		
		$authAdapter->setIdentity($username)
    				->setCredential($password);
    				
    	$auth = Zend_Auth::getInstance();  
 		$result = $auth->authenticate($authAdapter);  
    	
 		if ($auth->hasIdentity()){
 			$userInfo = $authAdapter->getResultRowObject(null, 'password'); 
 			Session::set("auth_user", $userInfo);
 			//Acl::getUserRights($userInfo->id);
 			return true; 	
 		}else{
 			return false;
 		}
	}
	
	public function deauth(){
		Session::set("auth_user", null);
		Session::set("acl_roles", null);
	}
	
	public function getIdentity(){
		return Session::get("auth_user");
	}
} 
?>