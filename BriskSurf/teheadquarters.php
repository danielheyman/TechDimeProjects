<?php
include("cleanConfig.php");


//MEMBERS ID
$user = filter_var($_GET['u'], FILTER_SANITIZE_NUMBER_INT);

//SURF REQUIREMENT
$surf = filter_var($_GET['s'], FILTER_SANITIZE_NUMBER_INT);

if (is_numeric($user) AND is_numeric($surf))
{
  $get = mysql_query("SELECT `dailyViews` FROM `users` WHERE `id`=$user LIMIT 1");
  if ($row = mysql_fetch_object($get))
  {
    if ($row->dailyViews >= $surf) //Have they surfed enough?
    {
      $talkback = 'goodtogo';  //Awesome! They did it!
    }
    else
    {
      $talkback = 'notenough';  //Guess not. Still needs to surf more.
    }
  }
  else
  {
    $talkback = 'notfound'; // Call the search & rescue!! Could not find this member ..
  }
}
else
{
  $talkback = 'noinfo';  //empty .. nothing more
}
echo "$talkback";
mysql_close();
exit();
?>