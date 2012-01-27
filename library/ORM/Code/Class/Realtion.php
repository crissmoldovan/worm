<?php
/**
 * @TODO DOCUMENT
 */ 
abstract class Code_Class_Relation{
	protected $name;
	protected $targetClass;
	
	const TYPE_OUT = "out";
	const TYPE_IN = "in";
	
	/**
	 * 
	 * @return string
	 */
	abstract public function getType();
	/**
	 * @return the $name
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return the $targetClass
	 */
	public function getTargetClass() {
		return $this->targetClass;
	}

	/**
	 * @param field_type $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @param field_type $targetClass
	 */
	public function setTargetClass($targetClass) {
		$this->targetClass = $targetClass;
	}

	
	
}