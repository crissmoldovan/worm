<?php
/**
 * @TODO DOCUMENT
 */ 
class Code_Class_Attribute{
	private $name;
	private $type;
	private $length;
	private $default;
	private $accessLevel;
	private $hasSetter;
	private $hasGetter;
	private $isStatic;
	private $comments;
	
	const access_public = "public";
	const access_private = "private";
	const access_protected = "protected";
	
	public function __construct($name = null){
		if (is_null($name)) throw new Exception("INVALID ATTRIBUTE NAME SET IN CONSTRUCTOR");
		$this->name = $name;
		$this->type = Code_Types::string;
		$this->length = "45";
		$this->default = "";
		$this->accessLevel = Code_Class_Attribute::access_protected;
		$this->isStatic = false;
		$this->hasGetter = true;
		$this->hasSetter = true;
	}
	
	public function makeStatic(){
		$this->isStatic = true;
		$this->hasGetter = false;
		$this->hasSetter = false;
	}
	
	public function makeInstance(){
		$this->isStatic = false;
		$this->hasGetter = true;
		$this->hasSetter = true;
	}
	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return the $type
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @return the $length
	 */
	public function getLength() {
		return $this->length;
	}

	/**
	 * @return the $default
	 */
	public function getDefault() {
		return $this->default;
	}

	/**
	 * @return the $accessLevel
	 */
	public function getAccessLevel() {
		return $this->accessLevel;
	}

	/**
	 * @return the $hasSetter
	 */
	public function getHasSetter() {
		return $this->hasSetter;
	}

	/**
	 * @return the $hasGetter
	 */
	public function getHasGetter() {
		return $this->hasGetter;
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
	 * @param $type the $type to set
	 */
	public function setType($type) {
		$this->type = $type;
	}

	/**
	 * @param $length the $length to set
	 */
	public function setLength($length) {
		$this->length = $length;
	}

	/**
	 * @param $default the $default to set
	 */
	public function setDefault($default) {
		$this->default = $default;
	}

	/**
	 * @param $accessLevel the $accessLevel to set
	 */
	public function setAccessLevel($accessLevel) {
		$this->accessLevel = $accessLevel;
	}

	/**
	 * @param $hasSetter the $hasSetter to set
	 */
	public function setHasSetter($hasSetter) {
		$this->hasSetter = $hasSetter;
	}

	/**
	 * @param $hasGetter the $hasGetter to set
	 */
	public function setHasGetter($hasGetter) {
		$this->hasGetter = $hasGetter;
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
	
	
}