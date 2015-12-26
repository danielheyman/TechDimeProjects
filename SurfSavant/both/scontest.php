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
        height:375px;
        background:url(<?=$site['url']?>both/images/contest.png);
        background-position:center;
        margin:auto;
        background-repeat:no-repeat;
        margin-top:-188px;
        top:50%;
    }
    
    #cover{
        position:fixed;
        top:0;
        bottom:0;
        left:0;
        right:0;
    }
</style>
<div id="text"></div>
<a target="_blank" href="<?=$site['url'].$getVar?>"><div id="cover"></div></a>