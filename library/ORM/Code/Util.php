<?php
/**
 * @TODO DOCUMENT
 */ 
class Code_Util{
	public static function getClassNameFromDbTableName($tableName = null){
		if (is_null($tableName)) return;
		
		$tableName = strtoupper($tableName[0]).substr($tableName,1);
		for($i=0;$i<strlen($tableName);$i++){
			if($tableName[$i]=='_'){
				$tableName = substr($tableName, 0, $i)."_".strtoupper($tableName[$i+1]).substr($tableName, $i+2);
			}
		}
		return $tableName;
	}
	
	public static function getDAClassNameFromDbTableName($tableName = null){
		if (is_null($tableName)) return;
		
		$tableName = strtoupper($tableName[0]).substr($tableName,1);
		for($i=0;$i<strlen($tableName);$i++){
			if($tableName[$i]=='_'){
				$tableName = substr($tableName, 0, $i)."".strtoupper($tableName[$i+1]).substr($tableName, $i+2);
			}
		}
		return $tableName."DA";
	}
	
	public static function getMapperClassNameFromDbTableName($tableName = null){
		if (is_null($tableName)) return;
		return self::getClassNameFromDbTableName($tableName)."_Mapper";
	}
	
	public static function getPathFromClassName($className){
		$tmp = self::toZendStandard($className);
		$dirname = substr($tmp, 0, strrpos($tmp, DIRECTORY_SEPARATOR));
		return $dirname;
	}
	
	public static function getFileNameFromClassName($className){
		$tmp = self::toZendStandard($className);
		$dirname = substr($tmp, 0, strrpos($tmp, DIRECTORY_SEPARATOR));

		return str_replace($dirname, "", $tmp);
	}
	
	public static function toZendStandard($className){
		return str_replace("_", DIRECTORY_SEPARATOR , $className);
	}
}