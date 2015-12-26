<?php
class Layout 
{
    var $sec;
    
    //init
    public function __construct($sec)
    {
        $this->sec = $sec;
    }
    
    //cleanURL: returns get variable
    //two directories: loggedIn, loggedOut
    //404 error image: images/404.jpg
    public function cleanURL($loggedIn, $site)
    {
        $url = $this->sec->filter($_SERVER['REQUEST_URI']);
        $url = explode("?", $url);
        $url = $url[0];
        $url = str_replace($site["directory"], "", $url);
        if($url[strlen($url) - 1] == '/') $url = rtrim($url, '/');
        if(strlen($url) != 0 && $url[0] == '/') $url = ltrim($url, '/');
        $url = explode("/", $url);
        if((count($url) == 1 && is_numeric($url[0])) || (count($url) == 01&& $url[0] == "") || count($url) == 0)
        {
            if($loggedIn) $page = "loggedIn/home.php";
            else if(!$loggedIn) $page = "loggedOut/home.php";
            if(count($url) == 1) return [$page, $url[0]];
            else return [$page, false];
        }
        if($loggedIn && file_exists("loggedIn/" . $url[0] . ".php")) $page = "loggedIn/" . $url[0] . ".php";
        else if(!$loggedIn && file_exists("loggedOut/" . $url[0] . ".php")) $page = "loggedOut/" . $url[0] . ".php";
        else if(file_exists("./both/" . $url[0] . ".php")) $page = "both/" . $url[0] . ".php";
        else if(!$loggedIn && file_exists("loggedIn/" . $url[0] . ".php")) $page = "loggedOut/login.php";
        else if($loggedIn && file_exists("loggedOut/" . $url[0] . ".php")) $page = "loggedIn/home.php";
        else die("<center><br/><h3>Sorry, this page does not exist. Click <a href='{$site["url"]}'>here</a> to go to our homepage.</h3><br/><!--<img src='{$site["url"]}images/404.jpg'/>-->");
        
        if($loggedIn && $page != "loggedIn/home.php" && $page != "loggedIn/commissions.php" && $page != "loggedIn/settings.php" && $page != "both/logout.php") $page = "loggedIn/home.php";

        if(count($url) == 2) return [$page, $url[1]];
        else return [$page, false];
    }
    
    //Create input buttons
    //$options is an array. must include name and type.
    //pretext is default text
    public function input($options, $defaultText = "")
    {
        $password = ($options["type"] == "password") ? true : false;
        if($password && $defaultText != "" && (!$this->sec->post($options["name"]) || $defaultText == $this->sec->post($options["name"]))) $options["type"] = "text";
        echo "<input";
        foreach($options as $key => $value) echo " " . $key . "='{$value}'";
        if(isset($options["name"]) && $this->sec->post($options["name"]))
            echo " value='{$this->sec->post($options['name'])}'";
        else if($defaultText != "") echo " value='{$defaultText}'";
        echo "/>";
        if($defaultText != "") echo "<script>$('input[name={$options['name']}]').focus(function(){  if($('input[name={$options['name']}]').val() == '{$defaultText}') { $('input[name={$options['name']}]').val(''); if('{$password}' == '1') $('input[name={$options['name']}]').get(0).type='password'; }}); $('input[name={$options['name']}]').blur(function(){  if($('input[name={$options['name']}]').val() == '') { $('input[name={$options['name']}]').val('{$defaultText}'); if('{$password}' == '1') $('input[name={$options['name']}]').get(0).type='text'; }});</script>";
    }
    
    //Create option buttons
    //$options is an array. must include name.
    //$values are the options of the select
    public function select($options, $values)
    {
        echo "<select";
        foreach($options as $key => $value) echo " " . $key . "='{$value}'";
        echo "/>";
        foreach($values as $key => $value){
            echo "<option value='{$key}' ";
            if(isset($options["default"]))
            {
                if($options["default"] == $key) echo "selected='true'";
            }
            else if(isset($options["name"]) && $this->sec->post($options["name"]) && $this->sec->post($options["name"]) == $key) echo "selected='true'";
            echo ">";
            echo $value . "</option>";
        }
        echo "</select>";
    }
}
?>