<?php
/****************************************************
xmlParser.class.php

This is the class file for the parser xml 2 array
and array to xml vise versa.

By: Prakash Panchal
****************************************************/

class xmlParser
{	 
	public function xml2array($contents, $get_attributes=1, $priority = 'tag') 
	{
    	if(!$contents) 
			return array();
    
    	if(!function_exists('xml_parser_create')) 
		{
        	return array();
    	}
	
		$parser = xml_parser_create('');
		xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); 
		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
		xml_parse_into_struct($parser, trim($contents), $xml_values);
		xml_parser_free($parser);
	
    	if(!$xml_values) 
			return;
	
		$xml_array = array();
		$parents = array();
		$opened_tags = array();
		$arr = array();
	
		$current = &$xml_array; 

    	$repeated_tag_index = array();
     
    	foreach($xml_values as $data) 
		{
        	unset($attributes,$value);
			
        	extract($data);

	        $result = array();
			
    	    $attributes_data = array();
        
  			if(isset($value)) 
			{
            	if($priority == 'tag') 
					$result = $value;
            	else 
					$result['value'] = $value; 
        	}
			
        	if(isset($attributes) and $get_attributes) 
			{
            	foreach($attributes as $attr => $val) 
				{
                	if($priority == 'tag') 
						$attributes_data[$attr] = $val;
                	else 
						$result['attr'][$attr] = $val;
            	}
        	}

        	if($type == "open") 
			{
            	$parent[$level-1] = &$current;
				if(!is_array($current) or (!in_array($tag, array_keys($current)))) 
				{ 
					$current[$tag] = $result;
					
					if($attributes_data) 
						$current[$tag. '_attr'] = $attributes_data;
						
					$repeated_tag_index[$tag.'_'.$level] = 1;
		
					$current = &$current[$tag];
		
				} 
				else 
				{ 
					if(isset($current[$tag][0])) 
					{
						$current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
						
						$repeated_tag_index[$tag.'_'.$level]++;
					} 
					else 
					{
						$current[$tag] = array($current[$tag],$result);
						
						$repeated_tag_index[$tag.'_'.$level] = 2;
						
						if(isset($current[$tag.'_attr'])) 
						{ 
							$current[$tag]['0_attr'] = $current[$tag.'_attr'];
							
							unset($current[$tag.'_attr']);
						}
		
					}
					$last_item_index = $repeated_tag_index[$tag.'_'.$level]-1;
					$current = &$current[$tag][$last_item_index];
				}

        	} 
			elseif($type == "complete") 
			{ 
				if(!isset($current[$tag])) 
				{ 
					$current[$tag] = $result;
					$repeated_tag_index[$tag.'_'.$level] = 1;
					if($priority == 'tag' and $attributes_data) 
						$current[$tag. '_attr'] = $attributes_data;
	
				} 
				else 
				{ 
					if(isset($current[$tag][0]) and is_array($current[$tag])) 
					{
						$current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
						
						if($priority == 'tag' and $get_attributes and $attributes_data) 
						{
							$current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
						}
						
						$repeated_tag_index[$tag.'_'.$level]++;
	
					} 
					else 
					{ 
						
						$current[$tag] = array($current[$tag],$result); 
						
						$repeated_tag_index[$tag.'_'.$level] = 1;
						
						if($priority == 'tag' and $get_attributes) 
						{
							if(isset($current[$tag.'_attr'])) 
							{     
								$current[$tag]['0_attr'] = $current[$tag.'_attr'];
								unset($current[$tag.'_attr']);
							}
							
							if($attributes_data) 
							{
								$current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
							}
						}
						$repeated_tag_index[$tag.'_'.$level]++; 
					}
				}
	
			} 
			elseif($type == 'close') 
			{
				$current = &$parent[$level-1];
			}
    	}
 
    	return($xml_array);
 	}
	 
 	public function array_to_xml($array, $level=1, $KeyForBlank = 'row') 
 	{
    	$xml = '';
		//echo "<pre>"; print_r($array); exit;
    	if ($level==1) 
		{
        	$xml .= '<?xml version="1.0" encoding="UTF-8"?>'.				
                "\n<interments>\n<response>\n";
    	}
		else if($level==11)
		{
			$xml .= '<?xml version="1.0"?>'.				
                "\n<list>\n";
		}
    	foreach ($array as $key=>$value) 
		{
        	$key = strtolower($key);
			$eleKey = $key;
        	
			if (is_array($value)) 
			{
				if(sizeof($value)) {
					if ( preg_match('/^\d+$/', $eleKey) ) $eleKey = $KeyForBlank;
					$xml .= str_repeat("\t",$level)."<$eleKey>\n";
					$level++;
					$xml .= $this->array_to_xml($value, $level, $KeyForBlank);
					$level--;
					$xml .= str_repeat("\t",$level)."</$eleKey>\n";
				} 
				else 
				{	
					if($eleKey == 'genre')
						$xml .= str_repeat("\t",$level)."<$eleKey> </$eleKey>\n";
					else
						$xml .= str_repeat("\t",$level)."<$eleKey />\n";
				}
			}
			else
			{
				if (trim($value)!='') 
				{
					if ( preg_match('/^\d+$/', $eleKey) ) $eleKey = $KeyForBlank;
					if (htmlspecialchars($value)!=$value || $this->otherchar($value)) 
					{
						$xml .= str_repeat("\t",$level).
								"<$eleKey><![CDATA[$value]]></$eleKey>\n";
					} 
					else 
					{
						$xml .= str_repeat("\t",$level).
							"<$eleKey><![CDATA[$value]]></$eleKey>\n";
					}
				}
				else 
				{
					if($eleKey == 'genre')
						$xml .= str_repeat("\t",$level)."<$eleKey> </$eleKey>\n";
					else
						$xml .= str_repeat("\t",$level)."<$eleKey />\n";
				}
			}
    	}
    	if ($level==1) 
		{
        	$xml .= "</response>\n</interments>";
    	}
		else if($level==11)
		{
			$xml .= "</list>";
		}
    	return $xml;
	}
 
	
	
	public function otherchar($str)
	{
		return preg_match('/\:/', $str);
	}
	
}
