<?php
/**
 * @TODO IMPLEMENT
 */ 


class Code_Class_Exporter_XML extends Model_Exporter_XML_Abstract{
	/* (non-PHPdoc)
	 * @see Model_Exporter_XML_Abstract::serialize()
	 */
	public static function getInstance($data){
		return new Code_Class_Exporter_XML($data);
	}
	
	public function serialize($valid = false) {
		return parent::serialize($valid);
	}

	
} 
?>