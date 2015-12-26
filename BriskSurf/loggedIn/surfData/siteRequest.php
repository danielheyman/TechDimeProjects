<?php
if(!isset($includedAlready)) include '../../cleanConfig.php';
//header('Content-Type: application/json');
$post = ['loggedIn' => $usr->loggedIn, 'error' => false, 'count' => true, 'addthis' => true];
if($usr->loggedIn)
{
    $code = md5($sec->randomCode());
    
    $days = $arrayManager->getCategory($vars, "Day");
    $weekday = 0;
    foreach ($days as $key => $value) {
        if($value == date("l")) $weekday = $key;
    }
    
    $db->query("UPDATE `users` SET `surfHash` = '{$code}' WHERE `id`='{$usr->data->id}'");
    if(false && $usr->data->dailyViews % 27 == 0 && $usr->data->dailyViews != 0 && $usr->data->surfedPage == 0)
    {
        $website = ["id" => "99999999999", "email" => "none@none.com", "url" => "http://www.surfsavant.com/hit/73yyk4", "membership" => "0001"];  
        $website = $object = json_decode(json_encode($website), FALSE);
    }
    else if($usr->data->dailyViews % 50 == 0 && $usr->data->dailyViews != 0 && $usr->data->surfedPage == 0)
    {
        /*$totalWonToday = 0.5 * $db->query("SELECT count(`id`) as `count` FROM `halloweenHunt` where `candy` = 'pumpkin' && `timestamp` >= DATE(NOW()) ")->getNext()->count;
        $totalWonToday += $db->query("SELECT count(`id`) as `count` FROM `halloweenHunt` where `candy` = 'ghost' && `timestamp` >= DATE(NOW()) ")->getNext()->count;

        $random = rand(1,20);
        if($totalWonToday <= 9.5 && $random == 1) $candy = "pumpkin";
        else if($totalWonToday <= 9 && $random == 2) $candy = "ghost";
        else
        {
            $random = rand(1,2);
            if($random == 1) $candy = "corn";
            else $candy = "skull";
        }
        $db->query("INSERT INTO `halloweenHunt` (`userid`, `candy`) VALUES ('{$usr->data->id}', '{$candy}')");

        $deals = [2,6,7,20,21,32];
        $deal = $deals[rand(0, count($deals) - 1)];
        $website = ["id" => "99999999999", "email" => "none@none.com", "url" => $site['url'] . "candy?c={$candy}&d={$deal}", "membership" => "0001"]; */ 
        $website = ["id" => "99999999999", "email" => "none@none.com", "url" => "http://bonus.techdime.com/bonus.php?type=brisksurf&surf=true", "membership" => "0001"];  
        $website = $object = json_decode(json_encode($website), FALSE);
    }
    else if(false && $usr->data->dailyViews % 3 == 0 && $usr->data->dailyViews != 0 && $usr->data->surfedPage == 0)
    {
        $website = ["id" => "99999999999", "email" => "none@none.com", "url" => "http://www.surfsavant.com/r/1", "membership" => "0001"];  
        $website = $object = json_decode(json_encode($website), FALSE);
    }
    else if(false && $usr->data->dailyViews % 35 == 0 && $usr->data->dailyViews != 0 && $usr->data->surfedPage == 0)
    {
        $website = ["id" => "99999999999", "email" => "none@none.com", "url" => "http://clicktrackprofit.com/badgesub.php?q=347ede394688f27bd04c", "membership" => "0001"];  
        $website = $object = json_decode(json_encode($website), FALSE);
    }
    else if(false && $usr->data->dailyViews % 77 == 0 && $usr->data->dailyViews != 0 && $usr->data->surfedPage == 0)
    {
        $website = ["id" => "99999999999", "email" => "none@none.com", "url" => "http://clicktrackprofit.com/badgesvault.php?q=347ede394688f27bd04c" , "membership" => "0001"];  
        $website = $object = json_decode(json_encode($website), FALSE);
    }
    else if(false && $usr->data->views == 0)
    {
        $website = ["id" => "99999999999", "email" => "none@none.com", "url" => "http://brisksurf.com/promo.html", "membership" => "0001"];  
        $website = $object = json_decode(json_encode($website), FALSE);
    }
    else
    {
        $website = $db->query("SELECT `websites`.`id`, `websites`.`url`,`user`.`membership`,`user`.`email` FROM `websites` LEFT OUTER JOIN (SELECT `users`.`email`, `users`.`id`, `users`.`membership` FROM `users` ) AS `user` ON `user`.`id` = `websites`.`userid` WHERE `userid` != '{$usr->data->id}' && `credits`>=1 && `status`='1' && `exceptions` NOT LIKE '%{$weekday}%' && `exceptions` NOT LIKE '%{$usr->data->gender}%' && `exceptions` NOT LIKE '%{$usr->data->age}%' && `exceptions` NOT LIKE '%{$usr->data->continent}%' && `exceptions` NOT LIKE '%{$usr->data->membership}%' && `reported` = '0' ORDER BY RAND() LIMIT 1");
        
        //SITE EXPLOSION
        
        /*$explosion = rand(1, 3);
        if($explosion == 1)
        {
            $website = $db->query("SELECT `websites`.`id`, `websites`.`url`,`user`.`membership`,`user`.`email` FROM `websites` LEFT OUTER JOIN (SELECT `users`.`email`, `users`.`id`, `users`.`membership` FROM `users` ) AS `user` ON `user`.`id` = `websites`.`userid` WHERE `userid` != '{$usr->data->id}' && `credits`>=1 && `status`='1' && `exceptions` NOT LIKE '%{$weekday}%' && `exceptions` NOT LIKE '%{$usr->data->gender}%' && `exceptions` NOT LIKE '%{$usr->data->age}%' && `exceptions` NOT LIKE '%{$usr->data->continent}%' && `exceptions` NOT LIKE '%{$usr->data->membership}%' && `reported` = '0' ORDER BY RAND() LIMIT 1");
        }
        else
        {
            $website = $db->query("SELECT `websites`.`id`, `websites`.`url`,`user`.`membership`,`user`.`email` FROM `websites` LEFT OUTER JOIN (SELECT `users`.`email`, `users`.`id`, `users`.`membership` FROM `users` ) AS `user` ON `user`.`id` = `websites`.`userid` WHERE `userid` != '{$usr->data->id}' && `credits`>=1 && `status`='1' && `exceptions` NOT LIKE '%{$weekday}%' && `exceptions` NOT LIKE '%{$usr->data->gender}%' && `exceptions` NOT LIKE '%{$usr->data->age}%' && `exceptions` NOT LIKE '%{$usr->data->continent}%' && `exceptions` NOT LIKE '%{$usr->data->membership}%' && `url` NOT LIKE '%explosion%' ORDER BY RAND() LIMIT 1");
        }*/
    }
    
    if((method_exists($website, "getNumRows") && $website->getNumRows()) || isset($website->url))
    {
        
        if(!isset($website->url))$website = $website->getNext();
        $email = md5(strtolower(trim($website->email)));
        
        
        $post['reportid3'] = (isset($_COOKIE['reportid2'])) ? $_COOKIE['reportid2'] : "-";
        $post['reporturl3'] = (isset($_COOKIE['reporturl2'])) ? $_COOKIE['reporturl2'] : "-";
        $post['reportid2'] = (isset($_COOKIE['reportid'])) ? $_COOKIE['reportid'] : "-";
        $post['reporturl2'] = (isset($_COOKIE['reporturl'])) ? $_COOKIE['reporturl'] : "-";
        $post['reportid'] = $website->id;
        $post['reporturl'] = $website->url;
        
        setcookie("reportid3", $post['reportid3'], time()+60*60*24*1, "/");
        setcookie("reporturl3", $post['reporturl3'], time()+60*60*24*1, "/");
        setcookie("reportid2", $post['reportid2'], time()+60*60*24*1, "/");
        setcookie("reporturl2", $post['reporturl2'], time()+60*60*24*1, "/");
        setcookie("reportid", $post['reportid'], time()+60*60*24*1, "/");
        setcookie("reporturl", $post['reporturl'], time()+60*60*24*1, "/");
        
        
        $post['url'] = $website->url;
        $post['email'] = $email;
        $post['time'] = $membership[$website->membership]["viewTime"];
        if($usr->data->id == 1 || $usr->data->id == 46) $post['time'] = 1;
        if(date("l") == "Friday") $post['time'] = floor($post['time'] / 2);
        $post['views'] = $usr->data->dailyViews;
        $post['type'] = rand(0,2);
        switch($post['type'])
        {
            case "0":
                $question = "Rate readibility";
                break;
            case "1":
                $question = "Rate design";
                break;
            case "2":
                $question = "Rate service";
                break;
        }
        
        $random =  rand(1, 10);
        if($random > 5 || $website->id == 99999999999)
        {
            $post['type'] = -1;
            $post['data'] = "<div id='continue'><a href='javascript:next()'><input type='submit' value='Next'/></a></div>";
        }
        else
        {
            $post['data'] = $question . "<br><div id='star'></div>
            <script>
            //$('#star').raty({ path: '{$site['url']}loggedIn/raty/img', number: 3, click: function(score, evt) { rated = score; $('#continue').show(); } });
            $('#star').raty({ path: '{$site['url']}loggedIn/raty/img', number: 3, click: function(score, evt) { rated = score; next(); } });</script>";
        }
        
        $post['data'] .= "
            <script>
            var nextCompletion = false;
            function next(){
                if($('#surf .count').html() == 'GO' && !nextCompletion)
                {
                    var data = {'id': '{$website->id}', 'type': {$post['type']}, 'rated': rated, 'redirect': redirect, 'social': social, 'surfHash': '{$code}', 'randomx': randomx, 'randomy': randomy};
                    postData(data, 'siteSubmit.php');
                    nextCompletion = true;
                }
            }
            </script>";
        
        if($website->id != 99999999999)
        {
            $post['data'] .= "
            
            <!-- AddThis Button BEGIN -->
            <div addthis:url='{$website->url}' class='addthis_toolbox addthis_32x32_style addthis_default_style'>
                <a class='addthis_button_facebook'></a>
                <a class='addthis_button_twitter'></a>
                <a class='addthis_button_google_plusone_share'></a>
                <a class='addthis_button_email'></a>
                <a class='addthis_button_compact'></a>
                <!--<a class='addthis_counter addthis_bubble_style'></a>-->
            </div>
            
            <!-- AddThis Button END -->
            <script>
            addthis.toolbox('.addthis_toolbox');
            setTimeout(function() { $('.addthis_toolbox').css('display','inline-block'); addthis.addEventListener('addthis.menu.share', shareEventHandler);}, 1000);
            
            function shareEventHandler(evt) { 
                if (evt.type == 'addthis.menu.share') { 
                    social = true;
                }
            }
            
            </script>
            ";
        }
        
        $apikey = "";
        switch($usr->data->dailyViews)
        {
            case 50:
                $apikey = "?bid=4977&key=d537f10f4c";
                break;
            case 100:
                $apikey = "?bid=4978&key=2354b1777a";
                break;
            case 250:
                $apikey = "?bid=4979&key=9b5b1d26c1";
                break;
            case 500:
                $apikey = "?bid=4980&key=e07e44cf12";
                break;
            case 1000:
                $apikey = "?bid=4981&key=4c3a3a2913";
                break;
        }
        if($apikey != "")
        {
            $code = @file_get_contents("http://clicktrackprofit.com/api.php" . $apikey);
            $post['badge'] = "<a target='_blank' href='http://clicktrackprofit.com/reloaded/claimbadge.php?{$code}'>
            <img src='http://clicktrackprofit.com/images/1brisksufrf{$usr->data->dailyViews}.png' height='90'/></a>";
        }
        
        $bonus = @file_get_contents("http://bonus.techdime.com/checkbonus.php?type=brisksurf&ip=" . $usr->visitorIP());
        if($bonus != "0") $post["bonus"] = $bonus;
    } 
    else $post['error'] = "There are no websites available to be surfed. <br>Click <a href='{$site['url']}'>here</a> to return to {$site['name']}.";
}
$db->query("UPDATE `users` SET `surfedPage` = 1 WHERE `id` = '{$usr->data->id}'");
echo json_encode($post);
?>