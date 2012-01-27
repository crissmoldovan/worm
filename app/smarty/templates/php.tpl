<?php

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
		if (count($class->getAttributes())){
			foreach($class->getAttributes() as $attribute){
	echo "
	
	/**
	 * ".$attribute->getComments()."
	 * @var ".$attribute->getType()."
	 */
	";
	echo $attribute->getAccessLevel()." "; if ($attribute->getIsStatic()) echo "static "; echo "$".$attribute->getName().";";			
				
			}
		} 
	
		if (count($class->getConstants())){
			foreach($class->getConstants() as $constant){
	
	echo "
	/**
	 * ".$constant->getComments()."
	 * @var ".$constant->getType()."
	 */
	const ".$constant->getName()." = '".$constant->getValue()."'
	";
				
				
			}
		} 
	?>
	
	/**
	* Converts the current object to an array and string some properties if param $exclude is true
	* 
	* @param boolean $exclude
	*/
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

	/**
	 * Sets the current object's properties from a given array (usually a result of an db query)
	 * 
	 * @param array $rs
	 */
	public function setFromRS($rs = null){
		if (! is_null($rs)){
			foreach($this as $key => $value){
				if (! is_null($rs[$key])) $this->$key = $rs[$key];
			}
		}
	}
}

?>