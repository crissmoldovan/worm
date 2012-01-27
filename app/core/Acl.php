<?php
/**
 * Controller access level and manages access rights
 * 
 * @author Cristian.Moldovan <cristi@ids-team.com>
 * @package CORE
 */
class Acl{
	
	/**
	 * Acl instance singleton
	 * @var unknown_type
	 */
	private static $aclDa = null;
	
	const ADD_ACTION = "ADD";
	const EDIT_ACTION = "EDIT";
	const DELETE_ACTION = "DEL";
	
	/**
	 * Public method that initializes the Acl instance
	 */
	public static function init(){
		self::$aclDa = AclDA::getInstance();
	}
	
	/**
	 * Retreive the access right for a speciffic user
	 * @todo - further docs
	 * @param integer $userID
	 */
	public static function getUserRights($userID = null){
		if (is_null(self::$aclDa)) self::init();
		
		if (is_null($userID)) return null;
		
		$roles = self::$aclDa->getRoles($userID);
		
		Session::set("acl_roles", $roles);
	}
	
	/**
	 * Checks is the current user is allowed to perform a specific action on a specific resource 
	 * 
	 * @param string $resourceType
	 * @param integer $resourceID
	 * @param string $action
	 */
	public static function hasRights($resourceType = null, $resourceID = null, $action = null){
		if (is_null(self::$aclDa)) self::init();
		if (is_null($resourceType) || is_null($action)) return false;
		
		$roles = Session::get("acl_roles");
		
		$allow = false;
		
		$authController = Auth::getInstance();
		$userInfo = $authController->getIdentity();
		Logger::write($roles);
		if (count($roles[$resourceType])){
			foreach ($roles[$resourceType] as $right){
				if ($right["ACTION"] == $action){
					if ($right["role_type"]=="SYSTEM"){
						switch($right["CONTEXT"]){
							case "ANY":
								$allow = true;
							break;
							case "OWNED":
								//@TODO handle OWNED logic
							break;
							case "SPECIFIC":
								//@TODO handle SPECIFIC logic
							break;
						}
					}else{
						// custom rights handling
						if(self::$aclDa->getCustomRights($resourceType, $resourceID, $userInfo->id, $right["role_id"], $right["role_type"])) $allow = true;
					}
				}
			}	
		}
		
		return $allow;
	}
	
	
}
?>