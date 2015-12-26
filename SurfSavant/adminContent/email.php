<?php

if(isset($newsletter_sending) && $newsletter_sending == true)
{
    $email = $newsletter_message;
    $subject = $newsletter_subject;
    if($newsletter_website == 1)
    {
        $banner = 'http://surfsavant.com/banner.png';
        $name = 'Surf Savant';
        $stats = 'http://surfsavant.com/adminContent/stats.php';
        $login = 'http://surfsavant.com';
        $color = '#2f3840';
        $from = 'Surf Savant <support@surfsavant.com>';
        $to = 'sendout@surfsavant.com';
    }
    else if($newsletter_website == 2)
    {
        $banner = 'http://brisksurf.com/banner.png';
        $name = 'BriskSurf';
        $stats = 'http://brisksurf.com/adminContent/stats.php';
        $login = 'http://brisksurf.com';
        $color = '#c74e4e';
        $from = 'BriskSurf <support@techdime.com>';
        $to = 'brisksurf@techdime.com';
    }
    else if($newsletter_website == 3)
    {
        $banner = 'http://surfduel.com/promo/banner.png';
        $name = 'SurfDuel';
        $stats = 'http://surfduel.com/adminContent/stats.php';
        $login = 'http://surfduel.com';
        $color = '#60dbe9';
        $from = 'SurfDuel <support@techdime.com>';
        $to = 'surfduel@techdime.com';
    }
    
    $stats = file_get_contents($stats);
    
    $html_email = file_get_contents("adminContent/template.html");
    $html_email = str_replace("[body_content]", str_replace("\n","<br>",$email), $html_email);
    $html_email = str_replace("[body_banner]", $banner, $html_email);
    $html_email = str_replace("[body_name]", $name, $html_email);
    $html_email = str_replace("[body_subject]", $subject, $html_email);
    $html_email = str_replace("[body_stats]", str_replace("\n","<br>",$stats), $html_email);
    $html_email = str_replace("[body_login]", $login, $html_email);
    $html_email = str_replace("[body_color]", $color, $html_email);
    $html_email = str_replace("[body_date]", date("F j, Y"), $html_email);
    
    /*$email = "Hiya %recipient_fname%,

{$email}

Here are some stats:
{$stats}

Wishing you great success,
Matt Baker, Daniel Heyman, & Yogesh Dhamija
{$login}

Feel like unsubscribing?
%mailing_list_unsubscribe_url%";*/
    
    if($newsletter_preview)
    {
        echo $html_email;
    }
    else
    {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, 'api:key-4vx645s6951qmql96cxuvsddz5g7x2m3');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v2/surfsavant.com/messages');
        curl_setopt($ch, CURLOPT_POSTFIELDS, array('from' => $from,
                                                     'to' => $to,
                                                     'subject' => $subject,
                                                     'html' => $html_email));
        
        $result = curl_exec($ch);
        curl_close($ch);
    }
}
?>