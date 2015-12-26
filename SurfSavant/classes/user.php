<?php
class User 
{
    var $db;
    var $sec;
    var $loggedIn = false;
    var $data;
    
    // init
    public function __construct($db, $sec)
    {
        $this->db = $db;
        $this->sec = $sec;
        if($this->sec->cookie("YDSESSION")) $this->getData();
    }
    
    public function getData(){
        $hash = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['HTTP_ACCEPT_LANGUAGE'] . $this->sec->cookie("YDSESSION"));
        $result = $this->db->query("SELECT `userid` FROM `sessions` WHERE `hash` = '{$hash}' LIMIT 1");
        if($result->getNumRows())
        {
            $userid = $result->getNext()->userid;
            
            $result = $this->db->query("SELECT * FROM `users` WHERE `id` = '{$userid}' && `activation` = '1' LIMIT 1");
            if($result->getNumRows())
            {
                $this->data = $result->getNext();
                $this->loggedIn = true;
                $this->db->query("UPDATE `sessions` SET `timestamp` = NOW() WHERE `hash` = '{$hash}' LIMIT 1");
                $this->db->query("UPDATE `users` SET `lastLogin` = NOW() WHERE `id` = '{$this->data->id}' LIMIT 1");
                $this->db->query("UPDATE `users` SET `loginIP` = '{$this->visitorIP()}' WHERE `id` = '{$this->data->id}' LIMIT 1");
            }
        }
    }
    
    //Get the machine IP
    public function visitorIP()
    { 
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $TheIp=$_SERVER['HTTP_X_FORWARDED_FOR'];
        else $TheIp=$_SERVER['REMOTE_ADDR'];
        return trim($TheIp);
    }
    
    //Redirect the page. Should be used for something like a logout
    public function redirect($url)
    {
        echo "<script>document.location.href='{$url}'</script>";
        exit;
    }
    
    //Logout the user
    public function logout()
    {
        if($this->sec->cookie("YDSESSION"))
        {
            $hash = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['HTTP_ACCEPT_LANGUAGE'] . $this->sec->cookie("YDSESSION"));
            $this->db->query("DELETE FROM `sessions` WHERE `hash` = '{$hash}'");
            setcookie("YDSESSION", "", time()-3600, "/");
        }
    }
    
    public function firstName()
    {
        return explode(" ", $this->data->fullName)[0];
    }
}
?>