<?php
class Model_Exporter_XML_Abstract{
	private $_instance = null;
	
	public function __construct($data){
		$this->_instance = $data;
	}
	public function serialize($valid = false){
		return Util_XML_Serializer::serialize($this->_instance, $valid);
	}
}