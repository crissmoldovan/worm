<?php
/**
 * @TODO DOCUMENT
 */ 
class Code_Class_Relation_Out extends Code_Class_Relation{
	
	private $refferencedAttribute;
	private $linkAttribute;
	
	public function getType(){
		return Code_Class_Relation::TYPE_OUT;
	}
	/**
	 * @return the $refferencedAttribute
	 */
	public function getRefferencedAttribute() {
		return $this->refferencedAttribute;
	}

	/**
	 * @param field_type $refferencedAttribute
	 */
	public function setRefferencedAttribute($refferencedAttribute) {
		$this->refferencedAttribute = $refferencedAttribute;
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