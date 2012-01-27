<?php
abstract class Model_Exporter_Abstract{
	protected $_instance = null;
	abstract public function toXML();
	
	public function __construct($instance){
		$this->_instance = $instance;
	}
	public function toJson(){
		return Zend_Json::encode($this->_instance);
	}
}