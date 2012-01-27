<?php
/**
 * @TODO DOCUMENT
 */ 
class Code_Class_Method{
	private $name;
	private $accessLevel;
	private $isStatic;
	private $returnType;
	private $comments;
	private $params;
	private $content;
	
	const access_public = "public";
	const access_private = "private";
	const access_protected = "protected";
	
	public function __construct($name = null){
		if (is_null($name)) throw new Exception("INVALID METHOD NAME SET IN CONSTRUCTOR");
		$this->name = $name;
		$this->returnType = Code_Types::void;
		$this->accessLevel = Code_Class_Attribute::access_protected;
		$this->isStatic = false;
		$this->params = array();
	}
	
	public function makeStatic(){
		$this->isStatic = true;
	}
	
	public function makeInstance(){
		$this->isStatic = false;
	}
	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return the $accessLevel
	 */
	public function getAccessLevel() {
		return $this->accessLevel;
	}

	/**
	 * @return the $isStatic
	 */
	public function getIsStatic() {
		return $this->isStatic;
	}

	/**
	 * @return the $comments
	 */
	public function getComments() {
		return $this->comments;
	}

	/**
	 * @param $name the $name to set
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @param $accessLevel the $accessLevel to set
	 */
	public function setAccessLevel($accessLevel) {
		$this->accessLevel = $accessLevel;
	}

	/**
	 * @param $isStatic the $isStatic to set
	 */
	public function setIsStatic($isStatic) {
		$this->isStatic = $isStatic;
	}

	/**
	 * @param $comments the $comments to set
	 */
	public function setComments($comments) {
		$this->comments = $comments;
	}
	/**
	 * @return the $returnType
	 */
	public function getReturnType() {
		return $this->returnType;
	}

	/**
	 * @return the $params
	 */
	public function getParams() {
		return $this->params;
	}

	/**
	 * @param $returnType the $returnType to set
	 */
	public function setReturnType($returnType) {
		$this->returnType = $returnType;
	}


	public function addParam($param){
		$this->params[] = $param;
	}
	/**
	 * @return the $content
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * @param field_type $content
	 */
	public function setContent($content) {
		$this->content = $content;
	}

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
	
	public static function getMethodNameFromAttributeName($prefix = "get", $attributeName = null){
		if (is_null($attributeName)) throw new Exception("Invalid attribute name!!");
		$methodNameArray = explode("_", $attributeName);
		if (is_array($methodNameArray)){
			for ($i=0; $i<count($methodNameArray); $i++){
				$methodNameArray[$i] = ucfirst($methodNameArray[$i]);
			}
		}
		$methodName = $prefix.implode("", $methodNameArray);
		return $methodName;
	}
	
	public static function getMethodNameFromClassName($prefix = "", $className = null){
		if (is_null($className)) throw new Exception("Invalid class name give for method name conversion!");
		
		return str_replace("_", "", $className);
	}
	
	
}