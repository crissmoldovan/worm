<?php
/**
 * @TODO DOCUMENT
 */ 
class CodeWriter_Utils{
	
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
}