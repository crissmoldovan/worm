<?php
/**
 * @TODO DOCUMENT
 */ 
class Db_Mapper_TableToClass{
	
	/**
	 * 
	 * @param Db_Table $table
	 * @return Code_Class
	 */
	public static function map(Db_Table $table = null){
		if (is_null($table)) throw new Exception("INVALID TABLE PASSED FOR CONVERTION");
		
		$class = new Code_Class(Code_Util::getClassNameFromDbTableName($table->getName()));
		
		if($table->countColumns()){
			foreach($table->getColumns() as $column){
				$class->addAttribute(Db_Mapper_ColumnToAttribute::map($column));
			}
		}
		
		$enumColumns = $table->getEnumColumns();
		if (count($enumColumns)){
			foreach($enumColumns as $column){
				$values = $column->getEnumValues();
				if (count($values)){
					foreach($values as $value){
						$tableNameConst = new Code_Class_Constant($column->getName()."_".$value);
						$tableNameConst->setType(Code_Types::string);
						$tableNameConst->setValue($value);
						
						$class->AddConstatnt($tableNameConst);		
					}
				}
				
				$tableNameConst = new Code_Class_Constant($column->getName()."_DEFAULT");
				$tableNameConst->setType(Code_Types::string);
				$tableNameConst->setValue($column->getDefault());
						
				$class->AddConstatnt($tableNameConst);
			}
		}
		
		$tableNameConst = new Code_Class_Constant("table_name");
		$tableNameConst->setType(Code_Types::string);
		$tableNameConst->setValue($table->getName());
		$class->AddConstatnt($tableNameConst);
		
		self::generateGetters($class);
		self::generateSetters($class);
		self::generateDependecies($class, $table);
		
		return $class;
	}
	
	/**
	 * 
	 * @param Db_Table $table
	 * @return Code_Class
	 */
	public static function mapAbstract(Db_Table $table = null){
		if (is_null($table)) throw new Exception("INVALID TABLE PASSED FOR CONVERTION");
		
		$class = new Code_Class(Code_Util::getClassNameFromDbTableName($table->getName())."_Abstract");
		$class->setTemplate("model.abstract.php.tpl");
		if($table->countColumns()){
			foreach($table->getColumns() as $column){
				$class->addAttribute(Db_Mapper_ColumnToAttribute::map($column));
			}
		}
		
		$enumColumns = $table->getEnumColumns();
		if (count($enumColumns)){
			foreach($enumColumns as $column){
				$values = $column->getEnumValues();
				if (count($values)){
					foreach($values as $value){
						$tableNameConst = new Code_Class_Constant($column->getName()."_".$value);
						$tableNameConst->setType(Code_Types::string);
						$tableNameConst->setValue($value);
						
						$class->AddConstatnt($tableNameConst);		
					}
				}
				
				$tableNameConst = new Code_Class_Constant($column->getName()."_DEFAULT");
				$tableNameConst->setType(Code_Types::string);
				$tableNameConst->setValue($column->getDefault());
						
				$class->AddConstatnt($tableNameConst);
			}
		}
		
		$tableNameConst = new Code_Class_Constant("table_name");
		$tableNameConst->setType(Code_Types::string);
		$tableNameConst->setValue($table->getName());
		$class->AddConstatnt($tableNameConst);
		
		self::generateGetters($class);
		self::generateSetters($class);
		self::generateDependecies($class, $table);
		
		return $class;
	}
	
/**
	 * 
	 * @param Db_Table $table
	 * @return Code_Class
	 */
	public static function mapModel(Db_Table $table = null){
		if (is_null($table)) throw new Exception("INVALID TABLE PASSED FOR CONVERTION");
		
		$class = new Code_Class(Code_Util::getClassNameFromDbTableName($table->getName()));
		$class->setSuperclass(Code_Util::getClassNameFromDbTableName($table->getName())."_Abstract");
		return $class;
	}
	
	private static function generateGetters(Code_Class &$class){
		$attributes = $class->getAttributes();
		
		foreach ($attributes as $attribute){
			if ($attribute->getHasGetter()){
				
				$methodName = Code_Class_Method::getMethodNameFromAttributeName("get", $attribute->getName());
				
				$getter = new Code_Class_Method($methodName);
				$getter->setAccessLevel(Code_Class_Method::access_public);
				$getter->setReturnType($attribute->getType());
				$getter->setComments(" gets the ".$attribute->getName()." attribute");
				$getter->setContent("return ".print_r("$", true)."this->".$attribute->getName().";");
				$paramerer = new Code_Class_Method_Parameter($attribute->getName());
				$paramerer->setDefault($attribute->getDefault());
				$paramerer->setType($attribute->getType());
				$getter->addParam($paramerer);
				
				$class->addMethod($getter);
			}
		}
	}
	
	private static function generateSetters(Code_Class &$class){
		$attributes = $class->getAttributes();
		
		foreach ($attributes as $attribute){
			if ($attribute->getHasGetter()){
				
				$methodName = Code_Class_Method::getMethodNameFromAttributeName("set", $attribute->getName());
				
				$setter = new Code_Class_Method($methodName);
				$setter->setAccessLevel(Code_Class_Method::access_public);
				$setter->setReturnType($attribute->getType());
				$setter->setComments(" sets the ".$attribute->getName()." attribute");
				$setter->setContent("".print_r("$", true)."this->".$attribute->getName()." = ".print_r("$", true).$attribute->getName().";");
				
				$paramerer = new Code_Class_Method_Parameter($attribute->getName());
				$paramerer->setDefault($attribute->getDefault());
				$paramerer->setType($attribute->getType());
				$setter->addParam($paramerer);
				
				$class->addMethod($setter);
			}
		}
	}	
	
	private static function generateDependecies(Code_Class &$class, Db_Table $table){
		if (count($table->getRelations())){
			foreach ($table->getRelations() as $relation){
//				$relation = new Db_Table_Relation();
				if ($relation->getReferencedTable() != $table->getName()){
					$classRelation = new Code_Class_Relation_Out();
					$classRelation->setName($relation->getName());
					$classRelation->setTargetClass(Code_Util::getClassNameFromDbTableName($relation->getReferencedTable()));
					$classRelation->setRefferencedAttribute($relation->getReferencedColumnName());
					$classRelation->setLinkAttribute($relation->getColumnName());
					$class->addRelation($classRelation);
				}else{
					$classRelation = new Code_Class_Relation_In();
					$classRelation->setReffererClass(Code_Util::getClassNameFromDbTableName($relation->getTableName()));
					$classRelation->setName($relation->getName());
					$classRelation->setTargetClass(Code_Util::getClassNameFromDbTableName($relation->getReferencedTable()));
					$classRelation->setReffererAttribute($relation->getColumnName());
					$classRelation->setLinkAttribute($relation->getReferencedColumnName());
					
					$class->addRelation($classRelation);
				}
			}
		}

		
	}
	
}