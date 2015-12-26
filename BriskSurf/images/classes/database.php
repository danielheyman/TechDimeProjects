<?php
class Database 
{
    var $error = false;
    var $db;
    var $sec;
    var $insertID = 0;
    
    //init
    public function __construct($host, $user, $pass, $db, $sec)
    {
        @mysql_connect($host,$user,$pass);
        $this->db = @mysql_select_db($db);
        $this->sec = $sec;
    }
    
    /*
    function: SQL function type: update, insert
    table: table to use
    values: $array = [["type" => "post", "pass" => false, "value" => "daniel.heyman@gmail.com", "field" => "email", "valid" => "email", "exists" => "true", "min" => 10, "max" => 50], [second], [third], [fourth], [fifth]]; 
    name: name of the value
    Type 
        post
        compare - compare to another field to be the same. Such as confirming email or password.
    Pass: If it is a password to be encrypted, select true. false is default.
    Value: The value that was submitted
    Field
        If it is a post then this is the field to be submitted to in the SQL.
        If it is a compare then this is the field it is compared to.
    Valid
        Leave blank for no validity check.
        Checks if the value is valid against the selected type
        Examples: email, password
    Exists
        Default is false. Not valid for compare types. Only post types. Check if field with the value already exists in the SQL.
    Min: minimum length of value. Leave blank for no max.
    Max: maximum length of value. Leave blank for no max.
    Conditions: only valid for an update. $array = ["userid = 10", "email = 10"]
    */
    public function insertUpdate($function, $table, $values, $conditions = [])
    {
        foreach ($values as $key => $value) 
        { 
            if($value["type"] == "post")
            {
                if(!isset($value["value"])) return "The {$value['name']} field is invalid";
                else if(isset($value["name"]) && $value["name"] == strtolower($value["value"])) return "The {$value['name']} field is invalid";
                
                if(isset($value['valid']))
                {
                    switch($value["valid"])
                    {
                        case "email":
                            if(!$this->sec->isEmail($value["value"])) return "The {$value['name']} is invalid";
                            break;
                        case "user":
                            if(!$this->sec->isUser($value["value"])) return "The {$value['name']} is invalid";
                            break;
                        case "name":
                            if(!$this->sec->isName($value["value"])) return "The {$value['name']} is invalid";
                            break;
                        case "fullname":
                            if(!$this->sec->isFullName($value["value"])) return "The {$value['name']} is invalid";
                            break;
                        case "url":
                            if((substr($value["value"], 0, 7) !== 'http://') && (substr($value["value"], 0, 8) !== 'https://')) $values[$key]["value"] = 'http://' . $value["value"];
                            $value["value"] = $values[$key]["value"];
                            if(!$this->sec->isURL($value["value"])) return "The {$value['name']} is invalid";
                            break;
                    }
                }
                
                if(isset($value['exists']) && $this->query("SELECT id FROM `{$table}` WHERE `{$value['field']}`='{$value['value']}' LIMIT 1")->getNumRows())
                    return "The {$value['name']} already exists";
                else if(isset($value['min']) && strlen($value["value"]) < $value["min"]) return "The {$value['name']} must be a minimum of {$value['min']} characters";
                else if(isset($value['max']) && strlen($value["value"]) > $value["max"]) return "The {$value['name']} must be a maximum of {$value['max']} characters";
                
                if(isset($value['pass'])) $values[$key]["value"] = md5($value["value"]);
            }
            else if($value["type"] == "compare")
            {
                if(isset($value['pass'])) $value["value"] = md5($value["value"]);
                if(isset($value['pass'])) $values[$key]["value"] = $value["value"];
                foreach ($values as $value2) 
                { 
                    if($value2["name"] == $value["name"] && $value2["value"] != $value["value"]) return "The {$value['name']}s do not match";
                }
            }
        }
        if($function == "insert")
        {
            $query = "INSERT INTO `{$table}` (";
            $count = 0;
            foreach ($values as $value) 
            { 
                if($value["type"] == "post"){
                    if($count != 0) $query .= ", ";
                    $query .= "`{$value['field']}`";
                    $count++;
                }
            } 
            $query .= ") VALUES (";
            $count = 0;
            foreach ($values as $value) 
            { 
                if($value["type"] == "post"){
                    if($count != 0) $query .= ", ";
                    $query .= "'{$value['value']}'";
                    $count++;
                }
            }
            $query .= ")";
            $this->query($query);
            $this->insertID = mysql_insert_id();
        }
        else if($function == "update")
        {
            $query = "UPDATE `{$table}` SET ";
            $count = 0;
            foreach ($values as $value) 
            { 
                if($value["type"] == "post"){
                    if($count != 0) $query .= ", ";
                    $query .= "`{$value['field']}` = '{$value['value']}'";
                    $count++;
                }
            }
            $query .= " WHERE ";
            $count = 0;
            foreach ($conditions as $condition) 
            {
                if($count != 0) $query .= " && ";
                $query .= $condition;
                $count++;
            }
            $this->query($query);
        }
        return "success";
    }
    
    //create a quuery: returns false if it failes for any reason
    public function query($query) {
        $result = @mysql_query($query);
        if (!$result)
        {
            $this->error = mysql_error();
            return false;
        }
        $this->insertID = mysql_insert_id();
        return new DBResult($result);
    }
}

class DBResult
{
    var $result;
    var $numRows;
    
    public function __construct($result)
    {
        $this->result = $result;
    }
    
    public function getNext()
    {
        $result = @mysql_fetch_object($this->result);
        return $result;
    }
    
    public function getNumRows()
    {
        $result = ($this->numRows ? $this->numRows : @mysql_num_rows($this->result));
        return $result;
    }
}
?>