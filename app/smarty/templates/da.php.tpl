<?php
if (count($class->getConstants())){
	foreach($class->getConstants() as $constant){
		if ($constant->getName() == "managedClass"){
			$managedClass = $constant->getValue();
		}				
	}
}
echo "
<?php

/**
* ".$class->getComments()."
*
* @author ".$class->getAuthor()."
* @package ".$class->getPackage()."
* @subpackage ".$class->getSubpackage()."
* @version ".$class->getVersion()."
* @date: ".$class->getDate()."
*/

class ".$class->getName().""; if (! is_null($class->getSuperclass())) echo " extends ".$class->getSuperclass(); echo " {

	";
	?>
	
	private static $tableName = <?=$managedClass?>::table_name;
	private static $instance = null;
	
	
	/**
	 * @return <?=$class->getName()?>
	 */
	public static function getInstance(){
		if (is_null(self::$instance)) {
			self::$instance = new <?=$class->getName()?>(self::$tableName);
		}
		
		return self::$instance;
	}
}

?>