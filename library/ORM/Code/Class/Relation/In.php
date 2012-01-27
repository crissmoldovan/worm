<?php
/**
 * @TODO DOCUMENT
 */ 

class Code_Class_Relation_In extends Code_Class_Relation{
	
	private $reffererClass;
	private $reffererAttribute;
	private $linkAttribute;
	
	
	public function getType(){
		return Code_Class_Relation::TYPE_IN;
	}
	
	
	/**
	 * @return the $refererClass
	 */
	public function getReffererClass() {
		return $this->reffererClass;
	}

	/**
	 * @param field_type $refererClass
	 */
	public function setReffererClass($reffererClass) {
		$this->reffererClass = $reffererClass;
	}

	/**
	 * @return the $refferencedAttribute
	 */
	public function getReffererAttribute() {
		return $this->reffererAttribute;
	}

	/**
	 * @param field_type $refferencedAttribute
	 */
	public function setReffererAttribute($reffererAttribute) {
		$this->reffererAttribute = $reffererAttribute;
	}
	/**
	 * @return the $linkAttribute
	 */
	public function getLinkAttribute() {
		return $this->linkAttribute;
	}

	/**
	 * @param field_type $linkAttribute
	 */
	public function setLinkAttribute($linkAttribute) {
		$this->linkAttribute = $linkAttribute;
	}

	
	
}