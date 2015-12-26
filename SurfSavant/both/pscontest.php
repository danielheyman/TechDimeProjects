<?php header( 'Location: '.$site['url'].$getVar ); ?>
<style>
    body
    {
        margin:0;
        padding:0;
        background:#ffdda9;
    }
    
    #text{
        position:absolute;
        width:100%;
        min-width:750px;
        height:404px;
        background:url(<?=$site['url']?>both/images/contest2.png);
        background-position:center;
        margin:auto;
        background-repeat:no-repeat;
        margin-top:-290px;
        top:50%;
    }
    
    #shield{
        position:fixed;
        bottom:-200px;
        right:0;
        left:0;
        height:375px;
        background:url(<?=$site['url']?>res/img/shieldHuge.png);
        background-position:center;
        margin:auto;
        background-repeat:no-repeat;
        min-width:750px;
    }
    
    #cover{
        
        position:fixed;
        top:0;
        bottom:0;
        left:0;
        right:0;
    }
    
    #box{
        font-family: Frutiger,"Frutiger Linotype",Univers,Calibri,"Gill Sans","Gill Sans MT","Myriad Pro",Myriad,"DejaVu Sans Condensed","Liberation Sans","Nimbus Sans L",Tahoma,Geneva,"Helvetica Neue",Helvetica,Arial,sans-serif;
        font-size:20px;
        color:#444;
        position:fixed;
        top:50%;
        margin-top:-70px;
        text-align:center;
        left:0;
        right:0;
        min-width:750px;
    }
    
    #box div{
        display:inline-block;
        height:80px;
        line-height:37px;
        padding-left:80px;
        margin-left:20px;
        text-align:left;
    }
    
    #box img{
        border:0;
        position:absolute;
        border-radius:5px;
        -moz-border-radius:5px;
        -o-border-radius:5px;
        -webkit-border-radius:5px;
    }
</style>
<div id="text"></div>
<div id="shield"></div>
<div id="box">
    <img src="http://www.gravatar.com/avatar/<?=md5(strtolower(trim($db->query("SELECT `email` FROM `users` WHERE `id` = '{$getVar}'")->getNext()->email)))?>?s=80">
    <div><?=$db->query("SELECT `fullName` FROM `users` WHERE `id` = '{$getVar}'")->getNext()->fullName?> can't wait<br>to compete with you.</div>
</div>
<a target="_blank" href="<?=$site['url'].$getVar?>"><div id="cover"></div></a>