<?php include 'header.php'; ?>
<style>
    a.lightboxes
    {
        border:1px solid #D5D5D5;
        padding-right:10px;
        margin:8px;
        background:#f5f5f5;
        display:inline-block;
        color:#333;
        -moz-border-radius:5px;
        -o-border-radius:5px;
        -webkit-border-radius:5px;
        border-radius:5px;
        min-width:200px;
        text-align:left;
        -moz-transition: all .3s ease-in; 
        -o-transition: all .3s ease-in; 
        -webkit-transition: all .3s ease-in; 
        transition: all .3s ease-in; 
    }
    
    a.lightboxes:hover{
        background:#d0d0d0;
    }
    
    a.lightboxes img{
        -moz-border-top-left-radius:2px;
        -moz-border-bottom-left-radius:2px;
        -o-border-top-left-radius:2px;
        -o-border-bottom-left-radius:2px;
        -webkit-border-top-left-radius:2px;
        -webkit-border-bottom-left-radius:2px;
        border-top-left-radius:2px;
        border-bottom-left-radius:2px;
        margin-right:5px;
        border:0;
        height:40px;
        width:40px;
    }
</style>
<div class="row">
    <div class="col-md-8">
        <div class="widget stacked">
            <div class="widget-header">
                <i class="icon-group"></i>
                <h3>Directory</h3>
            </div>
            <div class="widget-content">
                <ul class="nav nav-tabs">
                    <?php
                    $numPerPage = 50;
                    if(strpos($getVar, "s-") === false && strpos($getVar, "i-") === false)
                    {
                        $getVar = explode("-", $getVar);
                        $page2 = (count($getVar) == 2) ? $getVar[1] : 0;
                        $page = $page2 * $numPerPage;
                        $getVar = $getVar[0];
                    }
                    $options = ["A - D", "E - H", "I - L", "M - P", "Q - T", "U - Z"];
                    for($x = 1; $x <= count($options); $x++)
                    {
                        $option = $options[$x - 1];
                        $selected = ($x == $getVar) ? "active " : "";
                        echo "<li class='{$selected}'><a href='{$site['url']}directory/{$x}'>{$option}</a></li>";
                    }
                    ?>
                    <li<?php if(strpos($getVar, "s-") !== false || strpos($getVar, "i-") !== false) echo " class='active'"; ?>><a href='#searchUsers' class="lightbox">Search</a></li>
                </ul>
                <div style="display:none;" class="searchUsers" id="searchUsers">
                    <center style="width:400px; height:150px; overflow:hidden;">
                        Please enter a search term:<br><br>
                        <input style="width:350px; padding: 0 12px;" type="text" class="form-control searchUser">
                        <br>
                        <button onclick="searchUser()" type="button" class="btn btn-primary">Search</button>
                        <br><br>
                    </center>
                </div>
                <script>
                function searchUser()
                {
                    window.location.href = "<?=$site['url']?>directory/s-" + $(".jquery-lightbox-html .searchUser").val();
                }
                </script>
                <br>
                <center>
                    <?php
                    if(strpos($getVar, "s-") === false && strpos($getVar, "i-") === false)
                    {
                        $selection = ($getVar == 1) ? "ABCD" : (($getVar == 2) ? "EFGH" : (($getVar == 3) ? "IJKL" : (($getVar == 4) ? "MNOP" : (($getVar == 5) ? "QRST" : "UVWXYZ"))));
                        $total = "";
                        for($x = 0; $x < strlen($selection); $x++)
                        {
                            if($x != 0) $total .= " ||";
                            $total .= " `fullName` LIKE '{$selection[$x]}%'";
                        }
                        $totalpages = $db->query("SELECT COUNT(`id`) AS `count` FROM `users` WHERE `activation` = '1' && ({$total})")->getNext()->count;
                        $totalpages = ceil($totalpages / $numPerPage);
                        $users = $db->query("SELECT `description`, `email`, `facebook`, `twitter`, `fullName` FROM `users` WHERE `activation` = '1' && ({$total}) ORDER BY `fullName` ASC LIMIT {$page},{$numPerPage}");
                    }
                    else if(strpos($getVar, "s-") === false)
                    {
                        $search = explode("-", $getVar)[1];
                        echo "User ID: <strong>{$search}</strong><br><br>";
                        $users = $db->query("SELECT `description`, `email`, `facebook`, `twitter`, `fullName` FROM `users` WHERE `activation` = '1' && `id` = '{$search}' LIMIT 1"); 
                        ?>
                        <script>
                        $(document).ready(function() {
                            setTimeout(function() {
                                $(".lightbox.lightboxes").click(); 
                            }, 500);
                        });
                        </script>
                        <?php
                    }
                    else
                    {
                        $search = explode("-", $getVar)[1];
                        $search = str_replace("%20", " ", $search);
                        echo "Search Term: <strong>{$search}</strong><br><br>";
                        $users = $db->query("SELECT `description`, `email`, `facebook`, `twitter`, `fullName` FROM `users` WHERE `activation` = '1' && `fullName` like '%{$search}%' ORDER BY `fullName` ASC LIMIT {$numPerPage}");   
                    }
                    if($users->getNumRows())
                    {
                        $count = 1;
                        while($user = $users->getNext())
                        {
                            $email = md5(strtolower(trim($user->email)));
                            $description = ($user->description != "") ? $sec->closetags($user->description) : "The user has not filled in a description.";
                            ?>
                            <style>a:hover{text-decoration:none;}</style>
                            <div style="display:none;" id="profileDescription<?=$count?>">
                                <img src='http://www.gravatar.com/avatar/<?=$email?>?s=75'> &nbsp; <b><?=$user->fullName?> has provided you with the following personal information:</b><br><div style='display:inline-block; font-size:20px; width:75px; text-align:center; position:absolute; margin-top:8px;'><?php if($user->facebook != "") { ?><a target="_blank" href="http://facebook.com/<?=$user->facebook?>"><i class="icon-facebook-sign"></i></a> <?php } if($user->twitter != "") { ?> <a target="_blank"  href="http://twitter.com/<?=$user->twitter?>"><i class="icon-twitter-sign"></i></a><?php } ?></div><?php if(!($user->twitter == "" && $user->facebook == "")) echo "<br>"; ?><hr>
                                <?=$description?>
                            </div>
                            <?php
                            if(strlen($user->fullName) > 17) $user->fullName = substr($user->fullName, 0, 14) . "...";
                            echo "<a class='lightbox lightboxes' href='#profileDescription{$count}'> <img src='http://www.gravatar.com/avatar/{$email}?s=40'> {$user->fullName}</a>";
                            $count++;
                        }
                    }
                    ?>
                    <br>
                    <ul class="pagination">
                        <?php
                        if(strpos($getVar, "s-") === false && strpos($getVar, "i-") === false)
                        {
                            if($page2 != 0) echo "<li><a href='{$site['url']}directory/{$getVar}-0'>&laquo;</a></li>";
                            for($x = 0; $x < $totalpages; $x++)
                            {
                                if($x >= $page2 - 2 && $x <= $page2 + 2)
                                {
                                    $active = ($page2 == $x) ? " class = 'active'" : "";
                                    $number = $x + 1;
                                    echo "<li {$active}><a href='{$site['url']}directory/{$getVar}-{$x}'>{$number}</a></li>";
                                }
                            }
                            $number = $totalpages - 1;
                            if($page2 != $number) echo "<li><a href='{$site['url']}directory/{$getVar}-{$number}'>&raquo;</a></li>";
                        }
                        ?>
                    </ul>

                </center>
            </div>
        </div>
    </div>
    <div class="col-md-4">	
        <div class="well">
            <h4>How it Works</h4>
            <p>Have a long forgotten lost friend? Use our directory to find anyone. </p>
        </div>			
    </div>
</div>
<?php include 'footer.php'; ?>