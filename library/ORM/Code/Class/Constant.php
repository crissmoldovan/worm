<?php
/**
 * @TODO DOCUMENT
 */ 
class Code_Class_Constant{
	private $name;
	private $value;
	private $type;
	private $comments;
	
	public function __construct($name = null){
		if (is_null($name)) throw new Exception("INVALID CONSTANT NAME PASSED IN CONDTRUCTOR");
		
		$this->name = str_replace(" ", "_", $name);
		$this->value = "";
		$this->type = Code_Types::string;
		$this->comments = "";
	}
	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return the $value
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @return the $type
	 */
	public function getType() {
		return $this->type;
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
		$this->name = str_replace(" ", "_", $name);
	}

	/**
	 * @param $value the $value to set
	 */
	public function setValue($value) {
		$this->value = $value;
	}

	/**
	 * @param $type the $type to set
	 */
	public function setType($type) {
		$this->type = $type;
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