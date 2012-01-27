<?php
/**
 * @TODO DOCUMENT
 */ 
class Code_Class_Exporter extends Model_Exporter_Abstract{
	
	public static function getInstance($data){
		return new Code_Class_Exporter($data);
	}
	/* 
	 * @see Model_Exporter_Abstract::toXML()
	 */
	public function toXML($valid = false) {
		return Code_Class_Exporter_XML::getInstance($this->_instance)->serialize($valid);
	}

	
}