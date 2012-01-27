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
* @date: ".$class->getDate();
if ($class->hasRelations()){
	foreach ($class->getRelations() as $relation){
		echo "\n* @uses ".$relation->getTargetClass();
	}
}
echo "
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
	const ".$constant->getName()." = '".$constant->getValue()."';
	";
				
				
			}
		} 
	if ($class->hasRelations()){
		foreach ($class->getRelations() as $relation){
			if($relation->getType() == Code_Class_Relation::TYPE_OUT){
			echo "
	/**
	*  Getter for associated ".$relation->getTargetClass()." object
	*  - generated based on PK ".$relation->getName()."
	* @return ".$relation->getTargetClass()."
	*/ \n";
?>
	public function get<?=Code_Class_Method::getMethodNameFromAttributeName(null, str_replace("_id", "", $relation->getLinkAttribute())."_".$relation->getTargetClass())?>(){
		$tmp = new <?=$relation->getTargetClass()?>();
		return $tmp->getMapper()->getOneBy('<?=$relation->getRefferencedAttribute()?>',$this-><?=$relation->getLinkAttribute()?>);
	}
<?php	
			}elseif ($relation->getType() == Code_Class_Relation::TYPE_IN){
				echo "
	/**
	*  Getter for associated ".$relation->getTargetClass()." object
	*  - generated based on PK ".$relation->getName()."
	* @return array (list of associated".$relation->getReffererClass()." objects)
	*/ \n";	
	if ($relation->getReffererAttribute() == "last_modified_by"){			
?>
	public function get<?=Code_Class_Method::getMethodNameFromClassName(null, $relation->getReffererClass())?>Modified(){
<?php }else{ ?>
	public function get<?=Code_Class_Method::getMethodNameFromClassName(null, $relation->getReffererClass())?>s(){
<?php } ?>	
		$tmp = new <?=$relation->getReffererClass()?>();
		$mapper = $tmp->getMapper();
		$data = $mapper->filter(
			array(
				array(
					"field" => "<?=$relation->getReffererAttribute()?>",
					"value" => $this-><?=$relation->getLinkAttribute()?>
				)
			)
		);
		
		return $data;
	}
<?php	
			}	
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
	
	/**
	* @return <?=$class->getName()?>_Mapper
	*/
	public function getMapper(){
		return <?=$class->getName()?>::staticGetMapper();
	}
	
	/**
	* @return <?=$class->getName()?>_Mapper
	*/
	public static function staticGetMapper(){
		return <?=$class->getName()?>_Mapper::getInstance();
	} 
	
	public function save(){
		$mapper = $this->getMapper();
		if ($this->id == null){
			$this->id = $mapper->insert($this->toArray());
		}else{
			$mapper->update($this->toArray(), $this->id);
		}
	}
	<?php
	echo "\n";
	if($class->getMethods()){
		foreach ($class->getMethods() as $method){
			$params = $method->getParams();
			$paramStr = "";
			$paramArray = array();
			if (count($params)){
				foreach ($params as $param){
					$tmp = "";
					if (Code_Types::isClass($param->getType())) $tmp .= $param->getType()." ";
					$tmp .= "".print_r("$", true).$param->getName()." = '".$param->getDefault()."'";
					$paramArray[] = $tmp;
				}
				$paramStr = implode(", ", $paramArray);
			}
			
			?>
	/**
	 * <?=ucfirst($method->getComments())?>
	 * 
<?php
	if (count($params)){
		foreach($params as $param){
?>
	 * @param <?=$param->getType()?> $<?=$param->getName()?>
<?php
		}
	}
echo "\n";

if ($method->getReturnType()!=Code_Types::void){
?>
	 * @return <?=$method->getReturnType()?>
<?php
echo "\n";
}
?>
	 */
	<?=$method->getAccessLevel()?> <?=$method->getIsStatic()?> function <?=$method->getName()?>(<?=$paramStr?>){
		<?=$method->getContent()."\n"?>
	}
<?php
echo "\n";
		}
	} 
	?>
}

?>