<?php
/**
 * @TODO DOCUMENT
 */ 
class Code_Generator{
	private static $smartyInstance = null;
	public static $smartyConfig = null;
	
	private static function init(){
		if (is_null(self::$smartyConfig)) throw new Exception("INVALID SMARTY CONFIG");
		
		if (is_null(self::$smartyInstance)) {

		}
	}
	
	public static function setGeneratorConfig($config){
		self::$smartyConfig = $config;
	}
	
	public static function generateCode(Code_Class $class, $fileOut = null, $overwrite = true){
		self::init();
		
		$templateName = $class->getTemplate();
		
		ob_start();
		
		include self::$smartyConfig["template_dir"].'/'.$templateName;
		$output = ob_get_clean();
		
		$directory = Code_Util::getPathFromClassName($class->getName());
		$fileName = Code_Util::getFileNameFromClassName($class->getName());
		$filePath = $directory.$fileName.".php";
		
		Code_Writer::write($filePath, $output, $fileOut, $overwrite);
		
		return $filePath;
	}
	
	public static function previewCode(Code_Class $class){
		self::init();
		
		$templateName = $class->getTemplate();
		
		ob_start();
		
		include self::$smartyConfig["template_dir"].'/'.$templateName;
		$output = ob_get_clean();
		
		return $output;
	}
}