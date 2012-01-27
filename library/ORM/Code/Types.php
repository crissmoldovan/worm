<?php
/**
 * @TODO DOCUMENT
 */ 
class Code_Types{
	const string = "string";
	const int = "integer";
	const bool = "boolean";
	const fload = "double";
	const void = "void";
	const date = "date";
	
	public static function isClass($type){
		if (
			$type == Code_Types::bool ||
			$type == Code_Types::date ||
			$type == Code_Types::fload ||
			$type == Code_Types::int ||
			$type == Code_Types::string ||
			$type == Code_Types::void
		) return false;
		return true;
	}
}