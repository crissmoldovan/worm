<?php
/**
 * @TODO DOCUMENT
 */ 
class Db_Mapper_TableToDA{
	
	/**
	 * 
	 * @param Db_Table $table
	 * @return Code_Class
	 */
	public static function map(Db_Table $table = null){
		if (is_null($table)) throw new Exception("INVALID TABLE PASSED FOR CONVERTION");
		
		$class = new Code_Class(Code_Util::getDAClassNameFromDbTableName($table->getName()));
		
		$class->setSuperclass("DA_Abstract");
		$class->setPackage("DA");
		
		$classCont = new Code_Class_Constant("managedClass");
		$classCont->setValue(Code_Util::getClassNameFromDbTableName($table->getName()));
		
		$class->AddConstatnt($classCont);
		$class->setTemplate("da.php.tpl");
		return $class;
	}
	
}