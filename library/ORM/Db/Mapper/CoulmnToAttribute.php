<?php
/**
 * @TODO DOCUMENT
 */ 
class Db_Mapper_ColumnToAttribute{
	
	/**
	 * 
	 * @param Db_Table_Column $column
	 * @return Code_Class_Attribute
	 */
	public static function map(Db_Table_Column $column){
		$attribute = new Code_Class_Attribute($column->getName());
		$attribute->setAccessLevel(Code_Class_Attribute::access_protected);
		$attribute->setHasGetter(true);
		$attribute->setHasSetter(true);
		$attribute->setIsStatic(false);
		$attribute->setLength($column->getLength());
		$attribute->setType(Db_Mapper_DbTypeToCodeType::map($column->getDataType()));
		
		return $attribute;
	}
}