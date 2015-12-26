<?php
$getVar = explode("-", $getVar);
$content = ($getVar[1] == "Yes") ? "1" : "0";
if($content == "1")
{
    $email = md5(strtolower(trim($usr->data->email)));
    $handle = curl_init("http://www.gravatar.com/avatar/{$email}?s=125&default=404");
    curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($handle);
    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    if($httpCode == 404) {
        $content = "0";
    }
    curl_close($handle);
}
if($content != "0") $db->query("UPDATE `users` SET `activeBranding` = '{$content}' WHERE `id` = '{$usr->data->id}'");
$result = $db->query("SELECT `url`, `refurl` FROM `activitySites` WHERE `active` = '{$getVar[0]}'");
$result = $result->getNext();

$formatURL = $sec->formatURL($result->url);

$video = $db->query("SELECT `downlineLink`, `techdimeRef`, `mattRef`, (SELECT `ref` FROM `videoRefs` WHERE `videoRefs`.`videoid` = `videos`.`id` && `videoRefs`.`userid` = '{$usr->data->ref}') AS `ref` FROM `videos` WHERE `downlineLink` like '%{$formatURL}%'");

if($video->getNumRows())
{
    $video = $video->getNext();
    
    $ref = $video->ref;
    if($ref == "")
    {
        $ref = (rand(0,1) == 0) ? $video->mattRef : $video->techdimeRef;
    }
    $url = $video->downlineLink . $ref;
    header('Location: ' . $url);
}
else if($result->refurl != "")
{
    header('Location: ' . $result->refurl);  
}
else
{
    header('Location: ' . $result->url);   
}
?>