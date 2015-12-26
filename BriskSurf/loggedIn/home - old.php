<?php include 'header.php'; ?>
<div class="title">Dashboard</div>
<!--<div class="menu">
    <a href="javascript:void()">Settings</a>
    <a href="javascript:void()">Weekday</a>
    <a href="javascript:void()">Gender</a>
    <a href="javascript:void()">Age</a>
    <a href="javascript:void()">Continent</a>
    <a href="javascript:void()">Membership</a>
</div>-->
<hr>
<div class="text">
    <a href="http://www.surfduel.com/cd.html"><div class="promo" style="background:#6ad3de; border-bottom:3px solid #b59a81; margin-bottom:0;">Something new is on its way...&nbsp;<div style="display:inline-block; float:right;" id="countdown"></div></div></a>
    <script>
    
        var _second = 1000;
        var _minute = _second * 60;
        var _hour = _minute * 60;
        var _day = _hour * 24;
        var distance = 5000;
        
        var count = 600;
        function showRemaining() {
            setTimeout(showRemaining, 1000);
            if(count == 600)
            {
                count = 0;
                $.get('<?=$site["url"]?>/loggedIn/servertime.php', function(data) {
                    distance = data;
                    if (distance >= 0) {
                        var days = Math.floor(distance / _day);
                        var hours = Math.floor((distance % _day) / _hour);
                        var minutes = Math.floor((distance % _hour) / _minute);
                        var seconds = Math.floor((distance % _minute) / _second);
            
                        document.getElementById('countdown').innerHTML = '';
                        document.getElementById('countdown2').innerHTML = '';
                        if(days != 0) document.getElementById('countdown').innerHTML += days + ' Days ';
                        if(hours != 0 && days < 2) document.getElementById('countdown').innerHTML += hours + ' Hours ';
                        if(minutes != 0 && days == 0 && hours < 2) document.getElementById('countdown').innerHTML += minutes + ' Minutes ';
                        if(seconds != 0 && hours == 0 && minutes < 2) document.getElementById('countdown').innerHTML += seconds + ' Seconds';
                        if(days != 0) document.getElementById('countdown2').innerHTML += days + ' Days ';
                        if(hours != 0 && days < 2) document.getElementById('countdown2').innerHTML += hours + ' Hours ';
                        if(minutes != 0 && days == 0 && hours < 2) document.getElementById('countdown2').innerHTML += minutes + ' Minutes ';
                        if(seconds != 0 && hours == 0 && minutes < 2) document.getElementById('countdown2').innerHTML += seconds + ' Seconds';
                    }
                    else
                    {
                        document.getElementById('countdown').innerHTML = 'You can almost touch it...';
                        document.getElementById('countdown2').innerHTML = 'You missed it...';
                    }
                });
            }
            else
            {
                distance = parseInt(distance) - parseInt(1000);
                if (distance >= 0) {
                    var days = Math.floor(distance / _day);
                    var hours = Math.floor((distance % _day) / _hour);
                    var minutes = Math.floor((distance % _hour) / _minute);
                    var seconds = Math.floor((distance % _minute) / _second);
            
                    document.getElementById('countdown').innerHTML = '';
                    document.getElementById('countdown2').innerHTML = '';
                    if(days != 0) document.getElementById('countdown').innerHTML += days + ' Days ';
                    if(hours != 0 && days < 2) document.getElementById('countdown').innerHTML += hours + ' Hours ';
                    if(minutes != 0 && days == 0 && hours < 2) document.getElementById('countdown').innerHTML += minutes + ' Minutes ';
                    if(seconds != 0 && hours == 0 && minutes < 2) document.getElementById('countdown').innerHTML += seconds + ' Seconds';
                    if(days != 0) document.getElementById('countdown2').innerHTML += days + ' Days ';
                    if(hours != 0 && days < 2) document.getElementById('countdown2').innerHTML += hours + ' Hours ';
                    if(minutes != 0 && days == 0 && hours < 2) document.getElementById('countdown2').innerHTML += minutes + ' Minutes ';
                    if(seconds != 0 && hours == 0 && minutes < 2) document.getElementById('countdown2').innerHTML += seconds + ' Seconds';
                    count++;
                }
                else
                {
                    document.getElementById('countdown').innerHTML = 'You can almost touch it...';
                    document.getElementById('countdown2').innerHTML = 'You missed it...';
                }
            }
        }
        showRemaining();
    </script>
    
    <?php if($usr->data->membership == 0001) { ?><a href="<?=$site["url"]?>upgrade"><div class="promo">Beta discounts and contest ending soon...<div style="display:inline-block; float:right;" id="countdown2"></div></div></a><?php } else {  ?> <div style="display:none;" id="countdown2"></div>  <?php } ?>
    <div class="subtitle">Stats</div>
    You have <div class="green"><?=$usr->data->credits?></div> credits available to be used<br>
    <?php if($usr->data->membership == 0001) { ?>
    You are a free member [<a href="<?=$site["url"]?>upgrade">Upgrade</a>]
    <?php } else {
        $date = date('F j, Y @ g:i A',strtotime($usr->data->membershipExpires));
        echo "You are a <a href='{$site['url']}upgrade'>" . $membership[$usr->data->membership]["name"]  . "</a> member [Expires {$date}]"; 
    } ?>
    <br><br>
    <div class="subtitle">Welcome Video</div>
    <iframe width="1280" height="750" src="http://www.youtube.com/embed/kUJ0azb9GbQ?rel=0&amp;hd=1" frameborder="0" allowfullscreen></iframe>
    <script>
        $(function() {
        
            // Find all YouTube videos
            var $allVideos = $("iframe[src^='http://www.youtube.com']"),
        
                // The element that is fluid width
                $fluidEl = $("body");
        
            // Figure out and save aspect ratio for each video
            $allVideos.each(function() {
        
                $(this)
                    .data('aspectRatio', this.height / this.width)
                    
                    // and remove the hard coded width/height
                    .removeAttr('height')
                    .removeAttr('width');
        
            });
        
            // When the window is resized
            // (You'll probably want to debounce this)
            $(window).resize(function() {
        
                var newWidth = $("#content .content .text").width();
                if(newWidth > 700) newWidth = 700;
                
                // Resize all videos according to their own aspect ratio
                $allVideos.each(function() {
        
                    var $el = $(this);
                    $el
                        .width(newWidth)
                        .height(newWidth * $el.data('aspectRatio'));
        
                });
        
            // Kick off one resize to fix all videos on page load
            }).resize();
        
        });
    </script>
    <br><br>
    <div class="subtitle">Contest</div>
    We have a contest going on! The more people you refer, the more money you win. Try to refer as many people as possible. You will win if you reach above the 50th place in our rankings. To refer, ask people to sign up using the referral link found <a href="http://www.brisksu rf.com/promo">here</a>.
    <br><br>
    Contest ends on the 1st of September. The winners will see their winnings in their <a href="<?=$site["url"]?>commissions">commissions</a>. Make sure to update your Paypal email in the <a href="<?=$site["url"]?>settings">Settings</a>. Tied members will be ranked by their total views throughout their time in BriskSurf.<br><br>
    <div class="green">Prizes</div>: 
    <br>1st place: $50
    <br>2nd place: $25
    <br>3rd place: $10
    <br>4th - 10th place: $5
    <br>11th - 25th place: $2
    <br>26th - 50th place: $1
    <br><br>Only referrals who have viewed a minimum of 20 websites will be able to qualify
    <br><br><div style='max-height:200px; overflow:auto;'><table>
        <tr class="first"><td><strong>Rank</strong></td><td><strong>Name</strong></td><td><strong>Referrals</strong></td></tr>
        <?php
            $results = $db->query("SELECT COUNT(DISTINCT `referral`.`registerIP`) AS `count`, `user`.`fullName` AS `name` FROM `users` AS `referral` LEFT OUTER JOIN `users` AS `user` ON `referral`.`ref` = `user`.`id` WHERE `referral`.`views` >= 20 && `referral`.`ref` != 0 GROUP BY `referral`.`ref` ORDER BY COUNT(DISTINCT `referral`.`registerIP`) desc, `user`.`views` desc LIMIT 50");
            $odd = true;
            $count = 1;
            while($result = $results->getNext())
            {
                if($odd)
                {
                    echo "<tr class='odd'>";
                    $odd = false;
                }
                else
                {
                    echo "<tr class='even'>";
                    $odd = true;
                }
                echo "<td>#{$count}</td><td>{$result->name}</td><td>{$result->count}</td></tr>";
                $count++;
            }
        ?>
    </table></div>
</div>
<?php include 'footer.php'; ?>