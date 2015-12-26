<?php
include '../../cleanConfig.php';
//header('Content-Type: application/json');
$post = ['data' => '<script>loading("The next page is loading"); postData({}, "siteRequest.php");</script>', 'loggedIn' => $usr->loggedIn, 'error' => false, 'count' => false];

if($usr->loggedIn)
{
    if(isset($_POST["data"])){
        $data_json = $_POST["data"];
        $JSONArray  = json_decode($data_json, true); //returns null if not decoded
        //Values can now be accessed like standard PHP array
        if($JSONArray !== null){
            if($JSONArray["rated"] === null) $JSONArray["rated"] = 0;
            if($JSONArray["id"] !== null && $JSONArray["type"] !== null && $JSONArray["rated"] !== null && $JSONArray["redirect"] !== null && $JSONArray["social"] !== null && $JSONArray["randomx"] !== null && $JSONArray["randomy"] !== null)
            {
                $code = $sec->filter($JSONArray["surfHash"]);
                $id = $sec->filter($JSONArray["id"]);
                $type = $sec->filter($JSONArray["type"]);
                $rated = $sec->filter($JSONArray["rated"]);
                $redirect = $sec->filter($JSONArray["redirect"]);
                $social = $sec->filter($JSONArray["social"]);
                $randomx = $sec->filter($JSONArray["randomx"]);
                $randomy = $sec->filter($JSONArray["randomy"]);
                $IR = 0;
                if($redirect) $IR++;
                if($social) $IR++;
                $days = $arrayManager->getCategory($vars, "Day");
                $weekday = 0;
                foreach ($days as $key => $value) {
                    if($value == date("l")) $weekday = $key;
                }
                if($usr->data->surfHash == $code)
                {
                    //$db->query("INSERT INTO `clicks` (`userid`, `mousex`, `mousey`) VALUES ('{$usr->data->id}', '{$randomx}', '{$randomy}')");
                    
                    //$checkcheater = $db->query("SELECT `id` FROM (SELECT * FROM `clicks` WHERE userid = '{$usr->data->id}' ORDER BY `id` DESC LIMIT 10) AS `new` GROUP BY `mousex`, `mousey` HAVING COUNT(`id`) >= 5")->getNumRows();
                    $checkcheater = false;
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
                    
                    $db->query("INSERT INTO `views` (`userid`, `siteid`, `IR`, `weekday`, `gender`, `age`, `continent`, `membership`, `rateType`, `rated`) VALUES ('{$usr->data->id}', '{$id}', '{$IR}', '{$weekday}', '{$usr->data->gender}', '{$usr->data->age}', '{$usr->data->continent}', '{$usr->data->membership}', '{$type}', '{$rated}')");
                    $credits = $membership[$usr->data->membership]['viewCredit'];
                    $bonus = @file_get_contents("http://bonus.techdime.com/checkbonus.php?type=brisksurf&ip=" . $usr->visitorIP());
                    if($bonus != "0") $credits = round($credits * (1 + ($bonus / 100)), 2);
                    if(date("l") == "Tuesday" && ($usr->data->dailyViews + 1) % 150 == 0) $credits += 30;
                    $autoAssign = $db->query("SELECT SUM(`autoAssign`) AS `autoAssign` FROM `websites` WHERE `userid`='{$usr->data->id}'");
                    $autoAssign = $autoAssign->GetNext()->autoAssign;
                    $db->query("UPDATE `websites` SET `credits` = `credits` + (`autoAssign` * {$credits} / 100) WHERE `userid`='{$usr->data->id}'");
                    $credits = $credits * (1 - ($autoAssign / 100));
                    
                    $db->query("UPDATE `users` SET `surfedPage` = 0, `views` = `views` + 1, `dailyViews` = `dailyViews` + 1, `credits` = `credits` + {$credits}, `surfManualReset` = `surfManualReset` + 1 WHERE `id` = '{$usr->data->id}'");
                    $db->query("INSERT INTO `surfHistory` (userid, `views`, `timestamp`) VALUES({$usr->data->id}, 1, DATE(NOW())) ON DUPLICATE KEY UPDATE views = views + 1");
                    $db->query("UPDATE `websites` SET `credits` = `credits` - 1, `views` = `views` + 1 WHERE `id` = '{$id}' && `credits` >= 1");
                    if($usr->data->views + 1 == 50)
                    {
                        $bonus = @file_get_contents("http://cash.techdime.com/checkbonus.php?type=brisksurf&ip=" . $usr->visitorIP());
                        if($bonus != "0")
                        {
                            @file_get_contents("http://cash.techdime.com/clearbonus.php?type=brisksurf&ip=" . $usr->visitorIP());
                            $db->query("INSERT INTO `brisksurf`.`transactions` (`id`, `userid`, `item_number`, `item_name`, `txn_id`, `amount`, `date`) VALUES (NULL, '0', '-1', 'Cash Bonus', '', '0', CURRENT_TIMESTAMP)");   
                            $id = $db->insertID;
                            $db->query("INSERT INTO `brisksurf`.`commissions` (`id`, `userid`, `transactionid`, `amount`, `status`) VALUES (NULL, '{$usr->data->id}', '{$id}', '3.00', '1')"); 
                            $post['data'] = '<script>changeText("Congratulations! $3.00 in cash bonus has been added to your commissions<br><br>Click <a href=\'' . $site["url"]  . 'commissions\'>here</a> to view the cash bonus.<br><br>Click <a href=\'javascript:postData({}, \"siteRequest.php\")\'>here</a> to continue surfing");</script>';
                        }
                    }
                    if($usr->data->ref != 0)
                    {
                        $result = $db->query("SELECT `membership` FROM `users` WHERE `id` = '{$usr->data->ref}'");
                        if($result->getNumRows())
                        {
                            $mem = $result->getNext()->membership;
                            $credits *= $membership[$mem]['refCredit'];
                            $db->query("UPDATE `users` SET `credits` = `credits` + {$credits} WHERE `id` = '{$usr->data->ref}'");
                        }
                    }
                    //$includedAlready = true;
                }
                else $post['error'] = "Error during request #4";
            }
            else 
            { 
                $post['error'] = "Error during request #3";
                $post['error'] .= ($JSONArray["id"] === null) ? "1" : "";
                $post['error'] .= ($JSONArray["code"] === null) ? "2" : "";
                $post['error'] .= ($JSONArray["type"] === null) ? "3" : "";
                $post['error'] .= ($JSONArray["rated"] === null) ? "4" : "";
                $post['error'] .= ($JSONArray["redirect"] === null) ? "5" : "";
                $post['error'] .= ($JSONArray["social"] === null) ? "6" : "";
                $post['error'] .= ($JSONArray["randomx"] === null) ? "7" : "";
                $post['error'] .= ($JSONArray["randomy"] === null) ? "8" : "";
            }
        }
        else $post['error'] = "Error during request #2";
    }
    else $post['error'] = "Error during request #1";
}
echo json_encode($post);
?>