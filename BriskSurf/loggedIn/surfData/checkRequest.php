<?php
include '../../cleanConfig.php';
//header('Content-Type: application/json');
$post = ['loggedIn' => $usr->loggedIn, 'error' => false, 'count' => true];

if($usr->loggedIn)
{
    if(isset($_POST["data"])){
        $data_json = $_POST["data"];
        $JSONArray  = json_decode($data_json, true); //returns null if not decoded
        //Values can now be accessed like standard PHP array
        if($JSONArray !== null){
            if($JSONArray["id"] !== null)
            {
                $id = $sec->filter($JSONArray["id"]);
                $code = md5($sec->randomCode());
                $db->query("UPDATE `users` SET `surfHash` = '{$code}' WHERE `id`='{$usr->data->id}'");
                $website = $db->query("SELECT `id`, `url`, (SELECT `email` FROM `users` WHERE `users`.`id` = `websites`.`userid`) AS `email` FROM `websites` WHERE `id`='{$id}' && `status`='0' && `userid`='{$usr->data->id}'LIMIT 1");
                if($website->getNumRows())
                {
                    $website = $website->getNext();
                    $email = md5(strtolower(trim($website->email)));
                        
                    $post['code'] = $code;
                    $post['url'] = $website->url;
                    $post['email'] = $email;
                    $post['time'] = $membership[$usr->data->membership]["viewTime"];
                    $post['data'] = "Did your website display correctly?<br><br><input type='submit' value='Yes'/>&nbsp;<input type='submit' value='No'/>
                    <script>
                        $('#surf .dropdown input[type=submit]').click(function()
                        {
                            var data = {'id': '{$id}', 'code': '{$code}', 'value': $(this).val()};
                            postData(data, 'checkSubmit.php');
                        });
                    </script>
                    ";
                }
                else $post['error'] = "Website not found";
            }
            else $post['error'] = "Error during request";
        }
        else $post['error'] = "Error during request";
    }
    else $post['error'] = "Error during request";
}
echo json_encode($post);
?>