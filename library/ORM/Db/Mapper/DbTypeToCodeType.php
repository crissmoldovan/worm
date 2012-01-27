<?php
/**
 * @TODO DOCUMENT
 */ 
class Db_Mapper_DbTypeToCodeType{
	public static function map($dbType){
		switch(strtoupper($dbType)){
			case 'TINYINT':
			case 'SMALLINT':
			case 'MEDIUMINT':
			case 'INT':
			case 'INTEGER':
			case 'BIGINT':
				return Code_Types::int;
			break;
			
			case 'FLOAT':
			case 'DOUBLE':
			case 'DOUBLE PRECISION':
			case 'REAL':
			case 'DECIMAL':
			case 'NUMERIC':
				return Code_Types::fload;
			break;
				
			case 'DATE':
			case 'DATETIME':
			case 'TIMESTAMP':
			case 'TIME':
			case 'YEAR':
				return Code_Types::date;
			break;
			
			case 'CHAR':
			case 'VARCHAR':
			case 'TINYBLOB':
			case 'TINYTEXT':
			case 'BLOB':
			case 'TEXT':
			case 'MEDIUMBLOB':
			case 'MEDIUMTEXT':
			case 'LONGBLOB':
			case 'LONGTEXT':
			case 'ENUM':	
				return Code_Types::string;
			break;
		}
	}
}