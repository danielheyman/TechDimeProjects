<?php
class Security 
{
    //init
    public function __construct()
    {
        
    }
    
    //$_GET filter: returns false if the variable does not exist
    public function get($key)
    {
        if(!isset($_GET[$key])) return false;
        return $this->filter($_GET[$key]);
    }
    
    //$_POST filter: returns false if the variable does not exist
    public function post($key)
    {
        if(!isset($_POST[$key])) return false;
        return $this->filter($_POST[$key]);
    }
    
    //$_COOKIE filter: returns false if the variable does not exist
    public function cookie($key)
    {
        if(!isset($_COOKIE[$key])) return false;
        return $this->filter($_COOKIE[$key]);
    }
    
    //$_COOKIE filter: returns false if the variable does not exist
    public function session($key)
    {
        if(!isset($_SESSION[$key])) return false;
        return $this->filter($_SESSION[$key]);
    }
    
    //filter a variable so it is safe
    public function filter($data) {
        $data = trim(htmlentities(strip_tags($data)));
        if (get_magic_quotes_gpc()) $data = stripslashes($data);
        $data = mysql_real_escape_string($data);
        return $data;
    }
    
    //checks if it is a valid email
    public function isEmail($email){
        return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email) ? true : false;
    }
    
    //checks if the username is valid
    public function isUser($username)
    {
        return (!preg_match('/^[a-z\d_]{3,20}$/i', $username)) ? false : true;
    }
    
    //checks for a valid name. Can only contain letters.
    public function isName($name)
    {
        return (preg_match('/[^a-zA-Z\s]/', $name)) ? false : true;
    }
    
    //checks for a valid name. Can only contain letters.
    public function isFullName($name)
    {
        return (!preg_match('/[^a-zA-Z-\s]/', $name) && strstr($name, ' ')) ? true : false;
    }
    
    //checks for a valid name. Can only contain letters.
    public function isURL($url)
    {
        return (filter_var($url, FILTER_VALIDATE_URL)) ? true : false;
    }
    
    //gets the site name with the extension
    public function formatURL($url)
    {
        $url = str_replace("http://", "", $url);
        $url = str_replace("https://", "", $url);
        $url = str_replace("www.", "", $url);
        $url = explode("?", $url)[0];
        $url = explode("#", $url)[0];
        $url = explode("/", $url)[0];
        return $url;
    }
    
    //6 letter code. can be used for new password, activating an account, coupons, etc.
    public function randomCode()
    {
        $length = 6;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $string = '';
        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $string;   
    }
    
    public function closetags($html) {
        $html = str_replace("<a", "<a target='_blank'", $html);
        preg_match_all('#<(?!meta|img|br|hr|input\b)\b([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
        $openedtags = $result[1];
        preg_match_all('#</([a-z]+)>#iU', $html, $result);
        $closedtags = $result[1];
        $len_opened = count($openedtags);
        if (count($closedtags) == $len_opened) {
            return $html;
        }
        $openedtags = array_reverse($openedtags);
        for ($i=0; $i < $len_opened; $i++) {
            if (!in_array($openedtags[$i], $closedtags)) {
                $html .= '</'.$openedtags[$i].'>';
            } else {
                unset($closedtags[array_search($openedtags[$i], $closedtags)]);
            }
        }
        return $html;
    }
}
?>