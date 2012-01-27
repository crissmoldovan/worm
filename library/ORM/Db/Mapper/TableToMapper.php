<?php
class Db_Mapper_TableToMapper{
	
	/**
	 * 
	 * @param Db_Table $table
	 * @return Code_Class
	 */
	public static function map(Db_Table $table = null){
		if (is_null($table)) throw new Exception("INVALID TABLE PASSED FOR CONVERTION");
		
		$class = new Code_Class(Code_Util::getMapperClassNameFromDbTableName($table->getName()));
		
		$class->setSuperclass("Model_Mapper_Abstract");
		$class->setPackage("Mappers");
		
		$classCont = new Code_Class_Constant("managedClass");
		$classCont->setValue(Code_Util::getClassNameFromDbTableName($table->getName()));
		
		$class->AddConstatnt($classCont);
		$class->setTemplate("mapper.php.tpl");
		return $class;
	}
	
	/**
	 * 
	 * @param Db_Table $table
	 * @return Code_Class
	 */
	public static function mapAbstract(Db_Table $table = null){
		if (is_null($table)) throw new Exception("INVALID TABLE PASSED FOR CONVERTION");
		
		$class = new Code_Class(Code_Util::getMapperClassNameFromDbTableName($table->getName())."_Abstract");
		
		$class->setSuperclass("Model_Mapper_Abstract");
		$class->setPackage("Mappers");
		
		$classCont = new Code_Class_Constant("managedClass");
		$classCont->setValue(Code_Util::getClassNameFromDbTableName($table->getName()));
		
		$class->AddConstatnt($classCont);
		$class->setTemplate("mapper.abstract.php.tpl");
		return $class;
	}
	
/**
	 * 
	 * @param Db_Table $table
	 * @return Code_Class
	 */
	public static function mapMapper(Db_Table $table = null){
		if (is_null($table)) throw new Exception("INVALID TABLE PASSED FOR CONVERTION");
		
		$class = new Code_Class(Code_Util::getMapperClassNameFromDbTableName($table->getName()));
		
		$class->setSuperclass(Code_Util::getMapperClassNameFromDbTableName($table->getName())."_Abstract");
		$class->setPackage("Mappers");
		
		$classCont = new Code_Class_Constant("managedClass");
		$classCont->setValue(Code_Util::getClassNameFromDbTableName($table->getName()));
		
		$class->AddConstatnt($classCont);
		$class->setTemplate("mapper.php.tpl");
		return $class;
	}
	
}