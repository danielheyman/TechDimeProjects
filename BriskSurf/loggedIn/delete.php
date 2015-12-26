<?php include 'header.php'; ?>
<div class="title">Contact Us</div>
<hr>
<div class="text">
    <?php
        if($getVar)
        {
            $query = $db->query("SELECT `credits` FROM `websites` WHERE `userid` = '{$usr->data->id}' && `id` = '{$getVar}'");
            if($query->getNumRows())
            {
                $credits = $query->getNext()->credits;
                $db->query("UPDATE `users` SET `credits` = `credits` + {$credits} WHERE `id` = '{$usr->data->id}'");
                $db->query("DELETE FROM `websites` WHERE `userid` = '{$usr->data->id}' && `id` = '{$getVar}'");
                echo "<div class='success'>The site has been deleted.</div>";
                $form = false;
                //send email with the activation code.
            }
            else echo "<div class='error'>The site was not found.</div>";
        }
    ?>
</div>
<?php include 'footer.php'; ?>