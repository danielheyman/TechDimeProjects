<?php
include 'cleanConfig.php';

/*$results = $db->query("SELECT id from
      ( SELECT DISTINCT fromid, toid
        FROM chat
      ) AS du
  JOIN
      chat AS tt
    ON  tt.fromid = du.fromid && tt.toid = du.toid
    AND tt.timestamp <
        ( SELECT timestamp AS ts
          FROM chat
          WHERE fromid = du.fromid 
          && toid = du.toid 
          ORDER BY ts DESC
          LIMIT 1 OFFSET 20
        ) limit 1000");*/

$results = $db->query("SELECT tt.fromid, tt.toid, tt.id from
      ( SELECT DISTINCT fromid, toid
        FROM chat
      ) AS du
  JOIN
      chat AS tt
    ON  tt.fromid = du.fromid && tt.toid = du.toid
    AND tt.timestamp >
        ( SELECT timestamp AS ts
          FROM chat
          WHERE fromid = du.fromid 
          && toid = du.toid 
          ORDER BY ts DESC
          LIMIT 1 OFFSET 19
        ) group by tt.fromid, tt.toid limit 1000");

if($results->getNumRows())
{
   while($result = $results->getNext())
   {
        $db->query("DELETE FROM `chat` WHERE `id` <= '{$result->id}' && ((`toid` = '{$result->toid}' && `fromid` = '{$result->fromid}') || (`fromid` = '{$result->toid}' && `toid` = '{$result->fromid}'))");
   }
}


$db->query("UPDATE `users` SET `membership` = '0001' WHERE `membershipExpires` < NOW()");


$arrayResult = $arrayManager->getCategory($vars, "Membership");
foreach ($arrayResult as $key => $value)
{
    if($key != 0)
    {
        $db->query("UPDATE `users` SET `membershipCredits` = NOW() + INTERVAL 1 MONTH, `credits` = `credits` + {$membership[$key]['monthlyCredits']} WHERE `membershipCredits` < NOW() && `membership` = '{$key}'");
    }
}

?>