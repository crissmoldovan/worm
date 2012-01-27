<?php
class Util_XML_Serializer {

    public static function serialize($data, $valid = true, $node_block='nodes', $node_name='node'){
    	if(is_object($data)) return self::generateValidXmlFromObj($data, $valid, $node_block, $node_name);
    	else return self::generateValidXmlFromArray($data, $valid, $node_block, $node_name);
    }

    private static function generateValidXmlFromObj($obj, $valid = true,  $node_block='nodes', $node_name='node') {
        return self::generateValidXmlFromArray($obj, $valid, $node_block, $node_name);
    }

    private static function generateValidXmlFromArray($array, $valid = true,  $node_block='nodes', $node_name='node') {
    	if ($valid) $xml = '<?xml version="1.0" encoding="UTF-8" ?>';
		else $xml = "";
		
        
        $xml .= self::generateXmlFromArray($array, $node_name);
        

        return $xml;
    }

    private static function generateXmlFromArray($array, $node_name) {
        $xml = '';
        
        if (is_array($array) || is_object($array)) {
        	if (count(array_keys($array))==0){
	            if (is_object($array) && method_exists($array, "toArray")){
	            	$array = $array->toArray();
	            }
        	}
        	
        	foreach ($array as $key=>$value) {
        			if (is_numeric($key)){
	        			if (is_scalar($value)){
	        				$xml .= '<node>'.$value.'</node>';
	        			}elseif(is_object($value) || is_array($value)){
	        				$xml .= '<node>'.self::serialize($value, false) . '</node>';
	        			}	
        			}else{
	        			if (is_scalar($value)){
	        				$xml .= '<'.$key.'>'.$value.'</'.$key.'>';
	        			}elseif(is_object($value) || is_array($value)){
	        				$xml .= '<'.$key.'>' . self::serialize($value, false) . '</'.$key.'>';
	        			}
        			}
	            }
        } else {
            $xml = $array;
        }

        return $xml;
    }

}