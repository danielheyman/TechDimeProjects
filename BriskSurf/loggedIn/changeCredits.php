<?php
include '../cleanConfig.php';
//header('Content-Type: application/json');
$post = ['loggedIn' => $usr->loggedIn, 'error' => false];

if($usr->loggedIn)
{
    if(isset($_POST["data"])){
        $data_json = $_POST["data"];
        $JSONArray  = json_decode($data_json, true); //returns null if not decoded
        //Values can now be accessed like standard PHP array
        if($JSONArray !== null){
            if($JSONArray["credits"] !== null && $JSONArray["id"] !== null)
            {
                $credits = $sec->filter($JSONArray["credits"]);
                $id = $sec->filter($JSONArray["id"]);
                if(is_numeric($credits) && $credits >= 0)
                {
                    $result = $db->query("SELECT `credits` FROM `websites` WHERE `id`='{$id}' && `userid`='{$usr->data->id}'");
                    $result2 = $db->query("SELECT `credits` FROM `users` WHERE `id`='{$usr->data->id}'");
                    if($result->getNumRows() && $result2->getNumRows())
                    {
                        $websiteCredits = $result->getNext()->credits;
                        $userCredits = $result2->getNext()->credits;
                        if($websiteCredits < $credits)
                        {
                            $changeCredits = $credits - $websiteCredits;
                            if($userCredits >= $changeCredits)
                            {
                                $newCredits = $userCredits - $changeCredits;
                                $db->query("UPDATE `websites` SET `credits` = '{$credits}' WHERE `id`='{$id}' && `userid`='{$usr->data->id}'");
                                $db->query("UPDATE `users` SET `credits` = '{$newCredits}' WHERE `id`='{$usr->data->id}'");
                                $post['websiteCredits'] = $credits;
                                $post['availableCredits'] = $newCredits;
                            }
                            else $post['error'] = "You do not have so many credits";
                        }
                        else if($websiteCredits > $credits)
                        {
                            $changeCredits = $websiteCredits - $credits;
                            $newCredits = $userCredits + $changeCredits;
                            $db->query("UPDATE `websites` SET `credits` = '{$credits}' WHERE `id`='{$id}' && `userid`='{$usr->data->id}'");
                            $db->query("UPDATE `users` SET `credits` = '{$newCredits}' WHERE `id`='{$usr->data->id}'");
                            $post['websiteCredits'] = $credits;
                            $post['availableCredits'] = $newCredits;
                        }
                        else $post['error'] = "There is no change to the credits";
                    }
                    else $post['error'] = "Invalid website";
                }
                else $post['error'] = "Invalid credit count";
            }
            else $post['error'] = "Error during request";
        }
        else $post['error'] = "Error during request";
    }
    else $post['error'] = "Error during request";
}
echo json_encode($post);
?>