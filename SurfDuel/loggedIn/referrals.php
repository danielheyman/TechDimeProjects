<?php include 'header.php'; ?>
<div class="header">Referrals</div>
    <?php
    $result = $db->query("SELECT COUNT(`ref`) AS `count` FROM `users` WHERE `ref` = '{$usr->data->id}'"); 
    $count = $result->getNext()->count;
    if($count == 0)
    {
        echo "<div class='error'>You do not have any referrals to be viewed.</div>";  
    }
    else
    {
        echo "<div class='content'>You have a total of {$count} referral";
        if($count != 1) echo "s";
        echo ".";
        
        $results = $db->query("SELECT `views`, `id`, `fullName`, `dailyViews` FROM `users` WHERE `ref` = '{$usr->data->id}'");
        if($results->getNumRows())
        {
            echo "<br><br><div style='max-height:200px; overflow:auto;'><table><tr class='first'><td><strong>Name</strong></td><td><strong>Surfed more than 20</strong></td><td><strong>Daily Views</strong></td></tr>";
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
                $surfed20 = ($result->views >= 20) ? "Yes" : "No";
                echo "<td>{$result->fullName}</td><td>{$surfed20}</td><td>{$result->dailyViews}</td></tr>";
                $count++;
            }
            echo "</table></div>";
        }
    }
    ?>

<?php include 'footer.php'; ?>