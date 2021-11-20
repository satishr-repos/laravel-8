<?php

namespace App\Helpers;

class Utils
{
    public static function array_search_id($search_value, $array, $id_path) 
    {
      
        if(is_array($array) && count($array) > 0) {
              
            foreach($array as $key => $value) {
      
                $temp_path = $id_path;
                  
                // Adding current key to search path
                array_push($temp_path, $key);
      
                // Check if this value is an array
                // with atleast one element
                if(is_array($value) && count($value) > 0) {
                    $res_path = Utils::array_search_id(
                            $search_value, $value, $temp_path);
      
                    if ($res_path != null) {
                        return $res_path;
                    }
                }
                else if($value == $search_value) {
                    // return join(" ", $temp_path);
                    return $temp_path;
                }
            }
        }
          
        return null;
    }
}