<!doctype html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="<?=$site["url"]?>loggedIn/style.css?version=1.001">
    <link rel="stylesheet" href="<?=$site["url"]?>msgGrowl/css/msgGrowl.css" type="text/css" media="screen" title="no title" charset="utf-8" />
    <link rel="icon" type="image/png" href="<?=$site["url"]?>favicon.ico">
    <script src="<?=$site["url"]?>jquery-latest.js" type="text/javascript"></script>
    <script type="text/javascript" charset="utf-8" src="<?=$site["url"]?>msgGrowl/js/msgGrowl.js"></script>
    <title><?=$site["name"]?></title>
    <meta name="description" content="<?=$site["description"]?>" />
    <script>
        $(document).ready(function(){  
            <?php if(false && !$sec->cookie("salePromo2")) { ?>
            $.msgGrowl ({
                title: "Save a whopping 50% on Platinum.",
                text: "Get 6 months free! That's 60 thousand credits, 50% commissions, and other amazing perks. If you are upgraded monthly, please contact support. Expires 8am EST.",
                sticky: true,
                position: "top-right",
                onClose: function () {
                    setCookie("salePromo2", ":D", 1);
                    location.reload();
                },
                onOpen: function () {
                    $('.msgGrowl').hover(function() {
                        $('.msgGrowl').css("opacity",".5");
                        $('.msgGrowl').css("cursor","pointer");
                    }, function() {
                        $('.msgGrowl').css("opacity",".9");
                    });
                    $('.msgGrowl-content').click(function() {
                        window.location = "<?=$site['url']?>upgrade";
                    });
                }
            });
            function setCookie(c_name,value,exdays)
            {
                var exdate=new Date();
                exdate.setDate(exdate.getDate() + exdays);
                var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
                document.cookie=c_name + "=" + c_value;
            }
            <?php } ?>
            $("#side .menu .openSubmenu").click(function(){
                html = $(this).html();
                if($('#content').css("left") != "0px")
                {
                    $('#content').stop().animate({
                        left: 0,
                        right: 0
                    }, 500, function() {
                        if($("#content .submenu .top[name = '" + html + "']").css("display") != "block")
                        {
                            showSideMenu();
                        }
                    });
                }
                else
                {
                    showSideMenu()
                }
                function showSideMenu()
                {
                    $("#content .submenu .top").hide();
                    $("#content .submenu .top[name = '" + html + "']").show();
                    $('#content').animate({
                        left: 240,
                        right: -240
                    }, 500);
                }
            });
            
            $("#content .content").click(function(){
                $('#content').stop().animate({
                    left: 0,
                    right: 0
                }, 500);
            });
        });
    </script>
</head>
<body>
    <?php 
    $query = $db->query("SELECT UNIX_TIMESTAMP(`end`) - UNIX_TIMESTAMP(NOW()) AS `end`, `count`, `display` FROM `sales` WHERE `end` > NOW() &&  `start` < NOW() && `count` > 0");
    $sale = false;
    if($query->getNumRows() && !$sec->cookie("salePromo"))
    {
        $query = $query->getNext();
        $display = '';
        if($query->display == '1') $display = "{$query->count} Left";
        else if($query->display == '2') $display = "" . $gui->timeFormat($query->end) . '<br>left';
        ?>
        <div id="promo" style="z-index: 10; position:absolute; right:50px; top:-90px; ?>"><a href="<?=$site['url']?>credits"><img style="border:0;" src="<?=$site['url']?>loggedIn/images/sale.png"></a></div>
        <div style="z-index: 10; position:absolute; right:20px; top:5px; "><a id="hidePromo" href="#">(Hide)</a><br><?=$display?></div>
        <style>
            #promo{
                -o-transition: margin 0.2s;
                -webkit-transition: margin 0.2s;
                transition: margin 0.2s;
            }

            #promo:hover{
                margin-top:90px;
            }

            #hidePromo:hover{
                color:red;
            }
        </style>
        <script>
        $("#hidePromo").click(function() {
            setCookie("salePromo", ":D", 1);
            location.reload();
        });
        function setCookie(c_name,value,exdays)
        {
            var exdate=new Date();
            exdate.setDate(exdate.getDate() + exdays);
            var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
            document.cookie=c_name + "=" + c_value;
        }
        </script>
    <?php } ?>
    <div id="side" style="overflow:auto;">
        <a href="<?=$site["url"]?>"><div class="logo">BETA 2</div></a>
        <div class="menu">
             <?php if($usr->data->membership == 0001) { ?><a href="<?=$site['url']?>upgrade"><div class="green">Membership Benefits</div></a><?php } ?>
            <a href="<?=$site['url']?>credits"><div class="green">Buy Credits</div></a>
            <div class="openSubmenu"><?=$usr->data->fullName?></div>
            <a href="<?=$site['url']?>"><div>Dashboard</div></a>
            <style>
            #side .menu div.orange {
                background: #f6921e;
                color: #fff;
            }
            #side .menu div.orange:hover {
                background: #f67400;
                color: #fff;
            }
            #side .menu div.blue {
                background: #5868b2;
                color: #fff;
            }
            #side .menu div.blue:hover {
                background: #3045b2;
                color: #fff;
            }
            </style>
            <div class="openSubmenu">My Websites</div>
            <div class="openSubmenu">Promotion</div>
            <a href="<?=$site['url']?>tutorials"><div>Tutorials</div></a>
            <a href="<?=$site['url']?>surf"><div>Surf Now!</div></a>
            <div class="openSubmenu">Help Me</div>
            <!--<a target="_blank" class="special special3" href="http://blog.techdime.com"><div>Blog</div></a>
            <a target="_blank" class="special special2" href="https://twitter.com/TechDimeLLC"><div>Twitter</div></a>-->
            <a target="_blank" class="special" href="http://www.techdime.com"><div>Copyright &copy; 2014 TechDime</div></a>
        </div>
    </div>
    <div id="content">
        <div class="submenu">
            <div class="top" name="<?=$usr->data->fullName?>">
                <a href="<?=$site['url']?>settings"><div>Settings</div></a>
                <a href="<?=$site["url"]?>logout"><div>Logout</div></a>
            </div>
            <div class="top" name="My Websites">
                <a href="<?=$site["url"]?>new"><div>Add New</div></a>
                <?php
                $query = $db->query("SELECT `id`,`name`,`status` FROM `websites` WHERE `userid` = '{$usr->data->id}'");
                while($row = $query->getNext())
                {
                    $url = ($row->status == "0") ? $site['url'] . "surf/" . $row->id : $site['url'] . "view/" . $row->id;
                    echo "<a href='{$url}'><div>{$row->name}</div></a>";
                }
                ?>
            </div>
            <div class="top" name="Promotion">
                <a href="<?=$site['url']?>promo"><div>Referrals</div></a>
                <a href="<?=$site['url']?>commissions"><div>Commissions</div></a>
            </div>
            <div class="top" name="Help Me">
                <a href="<?=$site['url']?>faq"><div>FAQ</div></a>
                <a href="<?=$site['url']?>tos"><div>TOS</div></a>
                <a target="_blank" href="http://www.techdime.com/support"><div>Contact Us</div></a>
            </div>
        </div>
        <div class="contentScroller">
            <div class="content">