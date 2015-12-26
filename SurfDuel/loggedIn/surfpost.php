<?php
if(!isset($includedAlready)) include '../cleanConfig.php';
//header('Content-Type: application/json');
$post = ['loggedIn' => $usr->loggedIn, 'error' => false, 'redirect' => false, 'count' => $usr->data->dailyViews, 'text' => ''];

$getNext = false;

if($usr->loggedIn)
{
    if(isset($_POST["data"])){
        $data_json = $_POST["data"];
        $JSONArray  = json_decode($data_json, true); //returns null if not decoded
    }
    if($JSONArray !== null)
    {
        $code = md5($sec->randomCode());
        //$_SESSION["surfHash"] = $code;
        //$db->query("UPDATE `users` SET `surfHash` = '{$code}' WHERE `id`='{$usr->data->id}' LIMIT 1");

        $id1 = "";
        if(isset($JSONArray["link1"]) && $JSONArray["link1"] !== null && $JSONArray["link1"] != "")
        {
            $link1 = $sec->filter($JSONArray["link1"]);
            $id1 = $sec->filter($JSONArray["id1"]);
            $link2 = $sec->filter($JSONArray["link2"]);
            $id2 = $sec->filter($JSONArray["id2"]);
            $winner = $sec->filter($JSONArray["winner"]);
            $randomx = $sec->filter($JSONArray["randomx"]);
            $randomy = $sec->filter($JSONArray["randomy"]);
            $db->query("INSERT INTO `clicks` (`userid`, `mousex`, `mousey`) VALUES ('{$usr->data->id}', '{$randomx}', '{$randomy}')");

            $checkcheater = $db->query("SELECT `id` FROM (SELECT * FROM `clicks` WHERE userid = '{$usr->data->id}' ORDER BY `id` DESC LIMIT 10) AS `new` GROUP BY `mousex`, `mousey` HAVING COUNT(`id`) >= 5")->getNumRows();

            if(false && $checkcheater)
            {
                $reason = "User using autoclicker or automating surf using javascript.";
                //$exists = $db->query("SELECT `id` FROM `techdime_cheaters`.`checks` WHERE `fullName` = '{$usr->data->fullName}' && `email` = '{$usr->data->email}' && `registerIP` = '{$usr->data->registerIP}' && `loginIP` = '{$usr->data->loginIP}' && `reason` like '{$reason}%' LIMIT 1")->getNumRows();
                $reason .= " Mouse: {$randomx}, {$randomy}";
                /*if(!$exists)
                {
                    $db->query("INSERT INTO `techdime_cheaters`.`checks` (`fullName`, `email`, `registerIP`, `loginIP`, `reason`) VALUES ('{$usr->data->fullName}', '{$usr->data->email}', '{$usr->data->registerIP}', '{$usr->data->loginIP}', '{$reason}')");
                }*/
                $db->query("UPDATE `users` SET `activation` = '2', `banReason` = '{$reason}' WHERE `id` = '{$usr->data->id}'");
                $post['error'] = "For security purposes, please exit out of the surf and return to continue.";
            }
            if($link1 != "" && $id1 != "" && $link2 != "" && $id2 != "")
            {
                $win = ($winner == "0") ? $id1 : $id2;
                $lose = ($winner == "0") ? $id2 : $id1;

                $db->query("UPDATE `websites` SET `views` = `views` + 1, `likes` = `likes` + 1 WHERE `id` = '{$win}' && `inSurf` = '1' LIMIT 1");   
                $db->query("UPDATE `websites` SET `views` = `views` + 1 WHERE `id` = '{$lose}' && `inSurf` = '1' LIMIT 1");   
            }
            else if($link1 != "" && $id1 == "0")
            {
                $result = $db->query("SELECT COUNT(`id`) AS `count` FROM `websites` WHERE `userid` = '{$usr->data->id}' && `enabled` = '1'");
                $count = $result->getNext()->count;
                if($usr->data->views - $count * 100 >= 100)
                {
                    if($count < $membership[$usr->data->membership]["maximumSites"])
                    {
                        $db->query("INSERT INTO `websites` (`url`,`userid`) VALUES ('{$link1}','{$usr->data->id}')");
                        $post['redirect'] = true;
                    }
                    else $post['error'] = "You have reached the maximum amount of active websites you may have.";
                }
                else $post['error'] = "You must surf another " . ( 100 - ($usr->data->views - $count * 100) ) . " websites before you can add your own site.";
            }

            if($id1 != "0")
            {
                $db->query("UPDATE `users` SET `surfedPage` = 0, `views` = `views` + 1, `dailyViews` = `dailyViews` + 1 WHERE `id` = '{$usr->data->id}'");
                if($usr->data->ref != 0)
                {
                    $result = $db->query("SELECT `membership` FROM `users` WHERE `id` = '{$usr->data->ref}'");
                    if($result->getNumRows())
                    {
                        $mem = $result->getNext()->membership;
                        $db->query("UPDATE `users` SET `views` = `views` + {$membership[$mem]['refViews']}, `dailyViews` = `dailyViews` + {$membership[$mem]['refViews']} WHERE `id` = '{$usr->data->ref}'");
                    }
                }   
                $usr->getData();
                $post['count'] = $usr->data->dailyViews;
            }
        }


        if($JSONArray["id1"] != "0")
        {
            if(isset($JSONArray["check"]) && $JSONArray["check"] != "")
            {
                $result = $db->query("SELECT COUNT(`id`) AS `count` FROM `websites` WHERE `userid` = '{$usr->data->id}' && `enabled` = '1'");
                $count = $result->getNext()->count;
                $sitelink = str_replace("&amp;", "&", html_entity_decode($sec->filter($JSONArray["check"])));
                $spam = @file_get_contents("http://techdime.com/spam.php?url=" . $sitelink);
                if($spam != "0") $post['error'] = "The inputed website has been suspended. If you beleive this is a mistake, please contact support.";
                else
                {
                    if($usr->data->views - $count * 100 >= 100)
                    {
                        if($count < $membership[$usr->data->membership]["maximumSites"])
                        {
                            $post['link1'] = $sitelink;
                            $post['id1'] = "0";
                            $post['link2'] = "";
                            $post['id2'] = "";
                        }
                        else $post['error'] = "You have reached the maximum amount of active websites you may have.";
                    }
                    else $post['error'] = "You must surf another " . ( 100 - ($usr->data->views - $count * 100) ) . " websites before you can add your own site.";
                }
            }
            else if($usr->data->views == 0 && $usr->data->membership == "0001")
            {
                $post['link1'] = "http://surfduel.com/promo";
                $post['link2'] = "";
                $post['id1'] = "1";
                $post['id2'] = "";
                $post['text'] = "Winner #1";
            }
            else if($usr->data->dailyViews % 100 == 0 && $usr->data->dailyViews != 0 && $usr->data->surfedPage == 0)
            {
                $post['link1'] = "http://bonus.techdime.com/bonus.php?type=brisksurf";
                $post['link2'] = "";
                $post['id1'] = "99999999";
                $post['id2'] = "";
                $post['text'] = "Surf Bonus";
            }
            else if($usr->data->winnerViews < 5)
            {
                $winner = $usr->data->winnerViews + 1;
                $query = $db->query("SELECT `url`, `id` FROM `websites` WHERE `winner` = '{$winner}' LIMIT 1");
                $db->query("UPDATE `users` SET `winnerViews` = `winnerViews` + 1 WHERE `id` = '{$usr->data->id}'");
                if($query->getNumRows())
                {
                    $firstResult = $query->getNext();
                    $secondResult = $query->getNext();
                    $post['link1'] = $firstResult->url;
                    $post['link2'] = "";
                    $post['id1'] = $firstResult->id;
                    $post['id2'] = "";
                    $post['text'] = "Winner #" . $winner;
                }
                else
                {
                    $getNext = true;
                }
            }
            else
            {
                $getNext = true;
            }
        }
    }
    else $post['error'] = "Error #1";
}

if($getNext)
{
    $rand = rand(1, 5);
    if($usr->data->dailyViews % 27 == 0 && $usr->data->dailyViews != 0 && $usr->data->surfedPage == 0)
    {
        $post['link1'] = "http://www.surfsavant.com/hit/yjxmhc";
        $post['id1'] = "99999999";
        $post['text'] = "VS.";
        
        $query = $db->query("SELECT `url`, `id` FROM `websites` WHERE `inSurf` = '1' && `reported` = '0' ORDER BY RAND() LIMIT 1");
        if($query->getNumRows() == 1)
        {
            $secondResult = $query->getNext();
            $post['link2'] = $secondResult->url;
            $post['id2'] = $secondResult->id;
        }
        else $post['error'] = "There are no websites available to be surfed. Please try again later.";  
    }
    else if($rand == 1)
    {
        $query = $db->query("SELECT `web`.`url`, `web`.`id` FROM (SELECT `id`, `url` FROM `websites` WHERE `inSurf` = '1' && `reported` = '0' ORDER BY (`likes` / `views`) DESC LIMIT 50) AS `web` ORDER BY RAND() LIMIT 1");
        if($query->getNumRows() == 1)
        {
            $firstResult = $query->getNext();
            $post['link1'] = $firstResult->url;
            $post['id1'] = $firstResult->id;
            
            $query = $db->query("SELECT `url`, `id` FROM `websites` WHERE `inSurf` = '1' && `reported` = '0' && `id` != '{$firstResult->id}' ORDER BY RAND() LIMIT 1");
            if($query->getNumRows() == 1)
            {
                $secondResult = $query->getNext();
                $post['link2'] = $secondResult->url;
                $post['id2'] = $secondResult->id;
                $post['text'] = "VS.";
            }
            else $post['error'] = "There are no websites available to be surfed. Please try again later.";  
        } 
        else $post['error'] = "There are no websites available to be surfed. Please try again later."; 
    }
    else if($rand == 2)
    {
        $query = $db->query("SELECT `web`.`url`, `web`.`id` FROM (SELECT `id`, `url` FROM `websites` WHERE `inSurf` = '1' && `reported` = '0' ORDER BY (`likes` / `views`) DESC LIMIT 100) AS `web` ORDER BY RAND() LIMIT 1");
        if($query->getNumRows() == 1)
        {
            $firstResult = $query->getNext();
            $post['link1'] = $firstResult->url;
            $post['id1'] = $firstResult->id;
            
            $query = $db->query("SELECT `url`, `id` FROM `websites` WHERE `inSurf` = '1' && `reported` = '0' && `id` != '{$firstResult->id}' ORDER BY RAND() LIMIT 1");
            if($query->getNumRows() == 1)
            {
                $secondResult = $query->getNext();
                $post['link2'] = $secondResult->url;
                $post['id2'] = $secondResult->id;
                $post['text'] = "VS.";
            }
            else $post['error'] = "There are no websites available to be surfed. Please try again later.";  
        } 
        else $post['error'] = "There are no websites available to be surfed. Please try again later."; 
    }
    else if($rand == 3)
    {
        $post['link1'] = "http://www.surfsavant.com/r/1";
        $post['id1'] = "99999999";
        $post['text'] = "VS.";
        
        $query = $db->query("SELECT `url`, `id` FROM `websites` WHERE `inSurf` = '1' && `reported` = '0' ORDER BY RAND() LIMIT 1");
        if($query->getNumRows() == 1)
        {
            $secondResult = $query->getNext();
            $post['link2'] = $secondResult->url;
            $post['id2'] = $secondResult->id;
        }
        else $post['error'] = "There are no websites available to be surfed. Please try again later.";  
    }
    else
    {
        $query = $db->query("SELECT `url`, `id` FROM `websites` WHERE `inSurf` = '1' && `reported` = '0' ORDER BY RAND() LIMIT 2");
        if($query->getNumRows() == 2)
        {
            $firstResult = $query->getNext();
            $secondResult = $query->getNext();
            $post['link1'] = $firstResult->url;
            $post['link2'] = $secondResult->url;
            $post['id1'] = $firstResult->id;
            $post['id2'] = $secondResult->id;
            $post['text'] = "VS.";
        }
        else $post['error'] = "There are no websites available to be surfed. Please try again later.";   
    }
}
if(!isset($post['id1']) || $post['id1'] != "0" || $post['id1'] != "")
{
    $db->query("UPDATE `users` SET `surfedPage` = 1 WHERE `id` = '{$usr->data->id}'");
}

if(isset($post['id2']))
{
    $post['reportid4'] = (isset($_COOKIE['reportid2'])) ? $_COOKIE['reportid2'] : "";
    $post['reporturl4'] = (isset($_COOKIE['reporturl2'])) ? $_COOKIE['reporturl2'] : "";
    $post['reportid3'] = (isset($_COOKIE['reportid'])) ? $_COOKIE['reportid'] : "";
    $post['reporturl3'] = (isset($_COOKIE['reporturl'])) ? $_COOKIE['reporturl'] : "";
    $post['reportid2'] = $post['id2'];
    $post['reporturl2'] = $post['link2'];
    $post['reportid'] = $post['id1'];
    $post['reporturl'] = $post['link1'];

    setcookie("reportid4", $post['reportid4'], time()+60*60*24*1, "/");
    setcookie("reporturl4", $post['reporturl4'], time()+60*60*24*1, "/");
    setcookie("reportid3", $post['reportid3'], time()+60*60*24*1, "/");
    setcookie("reporturl3", $post['reporturl3'], time()+60*60*24*1, "/");
    setcookie("reportid2", $post['reportid2'], time()+60*60*24*1, "/");
    setcookie("reporturl2", $post['reporturl2'], time()+60*60*24*1, "/");
    setcookie("reportid", $post['reportid'], time()+60*60*24*1, "/");
    setcookie("reporturl", $post['reporturl'], time()+60*60*24*1, "/");
}


echo json_encode($post);
?>