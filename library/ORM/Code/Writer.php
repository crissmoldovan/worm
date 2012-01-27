<?php
/**
 * @TODO DOCUMENT
 */ 
class Code_Writer{
	public static function write($fileName, $content, $output = null, $overwrite = true){
		if (is_null($fileName)) throw new Exception("INVALID FILENAME PROVIDED TO WRITE CODE");
		if (is_null($content)) throw new Exception("INVALID CONTENT PROVIDED TO WRITE CODE");
		
		if (is_null($output) || !is_dir($output)){
			$baseFolder = Config_Controller::getValueFromSection("orm", "outputFolder");
		}else{
			$baseFolder = $output;
		}
		
		$path = $baseFolder.DIRECTORY_SEPARATOR.$fileName;
		
		$folder = dirname($path);
		
		$folderArray = explode(DIRECTORY_SEPARATOR, str_replace($baseFolder, "", $folder));
		$currentFolder = $baseFolder;
		if (count($folderArray)){
			foreach($folderArray as $tmpFolder){
				if ($tmpFolder!=""){
					$currentFolder .= DIRECTORY_SEPARATOR.$tmpFolder;
					if (! is_dir($currentFolder)) @mkdir($currentFolder, 0777);
				}
			}
		}
		if ($overwrite){
			try{
				$fh = fopen($path, 'w+') or die("can't write: ".$path);
				fwrite($fh, $content);
				fclose($fh);
			}
			catch(Exception $ex){
				throw new Exception("CAN'T WRITE FILE -".$path."-");	
			}
		}else{
			if (! file_exists($path)){
				try{
					$fh = fopen($path, 'w+') or die("can't write: ".$path);
					fwrite($fh, $content);
					fclose($fh);
				}
				catch(Exception $ex){
					throw new Exception("CAN'T WRITE FILE -".$path."-");	
				}	
			}
		}
	}
}