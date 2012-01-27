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

	
	
}
?> ";