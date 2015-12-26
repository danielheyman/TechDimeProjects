<?php include 'header.php'; ?>
<div class="title">Dashboard</div>
<hr>
<div class="text">
    
    <!--<a target="_blank" href="http://kore4.com/?referer=introace"><div style="background:url(http://kore4.com/images/introducing.png); background-repeat:no-repeat; background-position:center 10px; border:1px solid #D5D5D5; border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px; -0-border-radius:5px; padding-top:80px; background-size:120px; text-align:center; color:#816e6e; font-size:20px; padding-bottom:10px;">Putting Affiliates Before All</div></a>
    <br>-->
    <!--<div style="padding:20px; text-align:center; background:#c54545; color:#fff; margin-bottom:30px; border-radius:5px;">
        <div class="weekday" style="font-size:20pt; font-weight:bold; margin-bottom:20px; text-shadow:0px 2px 5px #000; position:relative;">$100 Raffle Winner</div>
        <div class="weekday2" style="font-size:15pt; position:relative;">Congratulations to Rajiv Soyee for winning the raffle!</div>
    </div>-->
    <style> 
    .weekday {
        animation: slidein 1s;
        -webkit-animation: slidein 1s;
        -o-animation: slidein 1s;
        -moz-animation: slidein 1s;
    }
    
    @keyframes slidein
    {
    from {left: -1000px;}
    to {left: 0px;}
    }
    
    @-webkit-keyframes slidein /* Safari and Chrome */
    {
    from {left: -1000px;}
    to {left: 0px;}
    }
    
    @-o-keyframes slidein /* Safari and Chrome */
    {
    from {left: -1000px;}
    to {left: 0px;}
    }
    
    @-moz-keyframes slidein /* Safari and Chrome */
    {
    from {left: -1000px;}
    to {left: 0px;}
    }
    .weekday2 {
        animation: slidein2 2s;
        -webkit-animation: slidein2 2s;
        -o-animation: slidein2 2s;
        -moz-animation: slidein2 2s;
    }
    
    @keyframes slidein2
    {
    0% {right: -1000px;}
    50% {right: -1000px;}
    100% {right: 0px;}
    }
    
    @-webkit-keyframes slidein2
    {
    0% {right: -1000px;}
    50% {right: -1000px;}
    100% {right: 0px;}
    }
    
    @-o-keyframes slidein2
    {
    0% {right: -1000px;}
    50% {right: -1000px;}
    100% {right: 0px;}
    }
    
    @-moz-keyframes slidein2
    {
    0% {right: -1000px;}
    50% {right: -1000px;}
    100% {right: 0px;}
    }
    </style>
    
    
    <?php if(date("l") == "Tuesday" || date("l") == "Friday") { ?>
    <div style="padding:20px; text-align:center; background:#c54545; color:#fff; margin-bottom:30px; border-radius:5px;">
        <div class="weekday" style="font-size:20pt; font-weight:bold; margin-bottom:20px; text-shadow:0px 2px 5px #000; position:relative;">It's <?php echo (date("l") == "Tuesday") ? "Trendy Tuesday" : "Fast Friday"; ?>!</div>
        <div class="weekday2" style="font-size:15pt; position:relative;"><?php echo (date("l") == "Tuesday") ? "Get 30 credits bonus for every 150 pages surfed!" : "Surf and earn at twice the speed!"; ?></div>
    </div>
    <style> 
    .weekday {
        animation: slidein 1s;
        -webkit-animation: slidein 1s;
        -o-animation: slidein 1s;
        -moz-animation: slidein 1s;
    }
    
    @keyframes slidein
    {
    from {left: -1000px;}
    to {left: 0px;}
    }
    
    @-webkit-keyframes slidein /* Safari and Chrome */
    {
    from {left: -1000px;}
    to {left: 0px;}
    }
    
    @-o-keyframes slidein /* Safari and Chrome */
    {
    from {left: -1000px;}
    to {left: 0px;}
    }
    
    @-moz-keyframes slidein /* Safari and Chrome */
    {
    from {left: -1000px;}
    to {left: 0px;}
    }
    .weekday2 {
        animation: slidein2 2s;
        -webkit-animation: slidein2 2s;
        -o-animation: slidein2 2s;
        -moz-animation: slidein2 2s;
    }
    
    @keyframes slidein2
    {
    0% {right: -1000px;}
    50% {right: -1000px;}
    100% {right: 0px;}
    }
    
    @-webkit-keyframes slidein2
    {
    0% {right: -1000px;}
    50% {right: -1000px;}
    100% {right: 0px;}
    }
    
    @-o-keyframes slidein2
    {
    0% {right: -1000px;}
    50% {right: -1000px;}
    100% {right: 0px;}
    }
    
    @-moz-keyframes slidein2
    {
    0% {right: -1000px;}
    50% {right: -1000px;}
    100% {right: 0px;}
    }
    </style>
    <?php } ?>
    <div class="subtitle">Stats</div>
    You have <div class="green"><?=$usr->data->credits?></div> credits available to be used.<br>
    <?php if($usr->data->membership == 0001) { ?>
    You are a free member [<a href="<?=$site["url"]?>upgrade">Upgrade</a>]
    <?php } else {
        $date = date('F j, Y @ g:i A',strtotime($usr->data->membershipExpires));
        echo "You are a <a href='{$site['url']}upgrade'>" . $membership[$usr->data->membership]["name"]  . "</a> member [Expires {$date}]"; 
    } ?>

   <!-- <br><br>
    <div class="subtitle" style="color: #f6921e;">Trick or Treat Halloween Hunt</div>
    <a href="<?=$site["url"]?>halloween"><img style="width:100%; max-width:1200px;" src='<?=$site['url']?>images/halloween/promo/promo.png'></a>
    <br><br>
    <strong>How it works</strong>: Collect candies while surfing to earn cash prizes, and other great rewards! <a style="color:#f6921e" href="<?=$site["url"]?>halloween" >Click here to learn more!</a>-->
    <!--
    <br><br>
    <div class="subtitle" style="color:#289e48">Big Foot Badge Hunt</div>
    <a href="<?=$site["url"]?>hunt"><img src='http://www.clicktrackprofit.com/reloaded/badgehuntsept.jpg'></a>
    <br><br>
    <strong>How it works</strong>: The person who collects the most badge hunt badges will receive a $500 cash prize! if it's a tie, the prize will be split amongst the top collectors. On top of that, during the event Click Track Profit will be giving out tons of XP randomly when members collect the badges!
    <a style="color:#289e48" href="<?=$site["url"]?>hunt" >Click here to learn more!</a>
    -->
    <!--<div class="subtitle">Welcome Video</div>
    <iframe width="1280" height="720" src="http://www.youtube.com/embed/b4zBEW5ew4o?rel=0&autohide=1&showinfo=0&wmode=transparentfil" frameborder="0" allowfullscreen></iframe>
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
    </script>-->
</div>
<?php include 'footer.php'; ?>