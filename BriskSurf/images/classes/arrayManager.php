<?php
class arrayManager 
{
    
    //init
    public function __construct()
    {
        
    }
    
    //Returns an array from the variables for the specific category. Example: just gender specific codes
    public function getCategory($array, $category)
    {
        $newArray[0] = "Select " . $category;
        foreach($array as $arr)
        {
            if($arr[1] == $category) $newArray["{$arr[0]}"] = $arr[2];
        }
        return $newArray;
    }
}