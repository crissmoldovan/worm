<?php
/**
 * @TODO IMPLEMENT
 */ 

class Code_Class_Method_Parameter{
	private $name;
	private $type;
	private $default;
	
	public function __construct($name = null){
		if (is_null($name)) throw new Exception("INVALID METHOD PARAMETER NAME IN CONSTRUCTOR");
		
		$this->name = $name;
		$this->type = Code_Types::string;
		$this->default = "null";
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
	 * @return the $default
	 */
	public function getDefault() {
		return $this->default;
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
	 * @param $default the $default to set
	 */
	public function setDefault($default) {
		$this->default = $default;
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