<?php include 'header.php'; ?>
<div class="row">
    <?php
    if(isset($_POST["testimonialUpdate"]))
    {
        $desc = $_POST["testimonialUpdate"];
        if (get_magic_quotes_gpc()) $desc = stripslashes($desc);
        $desc = mysql_real_escape_string($desc);
        $db->query("UPDATE `users` SET `testimonial` = '{$desc}' WHERE `id` = '{$usr->data->id}'");
        ?>
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Well done!</strong> Your testimonial have been updated.
            </div>
        </div>
        <?php
        $usr->getData();
    }
    else if(isset($_POST["splashVideoUpdate"]))
    {
        $input = $sec->post("splashVideoUpdate");
        $db->query("UPDATE `users` SET `splashVideo` = '{$input}' WHERE `id` = '{$usr->data->id}'");
        ?>
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Well done!</strong> Your YouTube Splash ID have been updated.
            </div>
        </div>
        <?php
        $usr->getData();
    }
    ?>
    <div class="col-md-8">
        <div class="widget stacked">
            <div class="widget-header">
                <i class="icon-bullhorn"></i>
                <h3>Affiliate Tools</h3>
            </div>
            <div class="widget-content">
                <script>
                $(function() { 
                    
                  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                    localStorage.setItem('lastTab', $(e.target).attr('class'));
                  });
                
                  var lastTab = localStorage.getItem('lastTab');
                  if (lastTab) {
                      $('.'+lastTab).tab('show');
                  }
                });
                </script>
                
                
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#cash" class="cash" data-toggle="tab">Cash</a></li>
                    <li><a href="#referrals" class="referrals" data-toggle="tab">Referrals</a></li>
                    <li><a href="#interact" class="interact" data-toggle="tab">Interactive Splashes</a></li>
                    <li class=""><a href="#static" class="static" data-toggle="tab">Static Splashes</a></li>
                    <li class=""><a href="#banners" class="banners" data-toggle="tab">Banners</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="cash">
                        <strong>Pending Cash</strong><hr>
                        <?php
                        $result = $db->query("SELECT SUM(`amount`) AS `sum` FROM `commissions` WHERE `status` = '1' && `userid` = '{$usr->data->id}'");
                        $result2 = $db->query("SELECT SUM(`commissions`.`amount`) AS `sum` FROM `commissions`  LEFT JOIN `transactions` ON `transactions`.`id` = `commissions`.`transactionid` WHERE `status` = '1' && `commissions`.`userid` = '{$usr->data->id}' && ((DATE(`transactions`.`date`)  < DATE(NOW() - INTERVAL 13 DAY) && `commissions`.`amount` > 0) || (`commissions`.`amount` < 0))");


                        $sum = $result->getNext()->sum;
                        if($sum == "") $sum = "0";
                        $sum2 = $result2->getNext()->sum;
                        if($sum2 == "" || $sum2 < 0) $sum2 = "0";
            
                        echo "You have a total of &#36;{$sum} in unpaid commissions out of which &#36;{$sum2} is available.<br><br>";
                        ?>
                        <div style="max-height:300px;overflow:auto;"><table class="table table-bordered table-hover table-striped">
                            <thead><tr><th>Date</th><th>User</th><th>Amount</th><th>Item</th><th>Status</th></tr></thead>
                            <?php
                                $results = $db->query("SELECT `commissions`.`amount`, CASE WHEN (DATE(`transactions`.`date`) < DATE(NOW() - INTERVAL 13 DAY) || `commissions`.`amount` < 0) THEN 'Available' ELSE 'Grace Period' END AS `status`, (SELECT `users`.`fullName` FROM `users` WHERE `transactions`.`userid` = `users`.`id`) AS `fullName`, `transactions`.`date`, `transactions`.`item_name` FROM `commissions` LEFT JOIN `transactions` ON `transactions`.`id` = `commissions`.`transactionid` WHERE `status` = '1' && `commissions`.`userid` = '{$usr->data->id}' ORDER BY `commissions`.`id` DESC");

                                while($result = $results->getNext())
                                {
                                    if($result->fullName == "" || $result->fullName == $usr->data->fullName) $result->fullName = "You";
                                    $date = date('F j, Y @ g:i A',strtotime($result->date));
                                    $result->amount = (strpos($result->amount, "-") !== false) ? str_replace("-", "- $", $result->amount) : "$" . $result->amount;
                                    echo "<tr><td>{$date}</td><td>{$result->fullName}</td><td>{$result->amount}</td><td>{$result->item_name}</td><td>{$result->status}</td></tr>";
                                }
                            ?>
                        </table></div>
                        <br><br>
                        <strong>Paid Cash</strong><hr>
                        <?php
                        $result = $db->query("SELECT SUM(`amount`) AS `sum` FROM `commissions` WHERE `status` = '0' && `userid` = '{$usr->data->id}'");
                        $sum = $result->getNext()->sum;
                        if($sum == "") $sum = "0";
                        echo "You have a total of &#36;{$sum} in paid commissions<br><br>";
                        ?>
                        <div style="max-height:300px;overflow:auto;"><table class="table table-bordered table-hover table-striped">
                            <thead><tr><th>Date</th><th>User</th><th>Amount</th><th>Item</th></tr></thead>
                            <?php
                                $results = $db->query("SELECT `commissions`.`amount`, (SELECT `users`.`fullName` FROM `users` WHERE `transactions`.`userid` = `users`.`id`) AS `fullName`, `transactions`.`date`, `transactions`.`item_name` FROM `commissions` LEFT JOIN `transactions` ON `transactions`.`id` = `commissions`.`transactionid` WHERE `status` = '0' && `commissions`.`userid` = '{$usr->data->id}' ORDER BY `commissions`.`id` DESC");
                                while($result = $results->getNext())
                                {
                                    if($result->fullName == "" || $result->fullName == $usr->data->fullName) $result->fullName = "You";
                                    $date = date('F j, Y @ g:i A',strtotime($result->date));
                                    $result->amount = (strpos($result->amount, "-") !== false) ? str_replace("-", "- $", $result->amount) : "$" . $result->amount;
                                    echo "<tr><td>{$date}</td><td>{$result->fullName}</td><td>{$result->amount}</td><td>{$result->item_name}</td></tr>";
                                }
                            ?>
                        </table></div>
                        
                    </div>
                    <div class="tab-pane fade" id="referrals">
                        <?php
                        $result = $db->query("SELECT COUNT(`ref`) AS `count` FROM `users` WHERE `ref` = '{$usr->data->id}' && `activation` = '1'"); 
                        $count = $result->getNext()->count;
                        if($count == 0)
                        {
                            echo "<div class='error'>You do not have any referrals to be viewed.</div>";  
                        }
                        else
                        {
                            echo "You have a total of {$count} referral";
                            if($count != 1) echo "s";
                            echo ".";
                            
                            $results = $db->query("SELECT `membership`, (SELECT SUM(`amount`) FROM `transactions` WHERE `userid` = `users`.`id` && `item_number` != '99999') AS `amount`, `fullName`, `registerDate` FROM `users` WHERE `ref` = '{$usr->data->id}' && `activation` = '1' ORDER BY `id` DESC");
                            if($results->getNumRows())
                            {
                                echo "<br><br><div style='max-height:300px;overflow:auto;'><table class='table table-bordered table-hover table-striped'><thead><tr><th>Date Joined</th><th>Name</th><th>Membership</td><th>Amount Spent</td></tr></thead>";
                                while($result = $results->getNext())
                                {
                                    $cash = ($result->amount != "") ? number_format($result->amount,2) : "0.00";
                                    echo "<td>{$result->registerDate}</td><td>{$result->fullName}</td><td>{$membership[$result->membership]['name']}</td><td>$ {$cash}</td></tr>";
                                }
                                echo "</table></div>";
                            }
                        }
                        ?>
                    </div>
                    <div class="tab-pane fade" id="interact">
                        <center>
                            <?php if($usr->data->membership != '0001') { ?>
                            <div style="margin-bottom:20px; padding-bottom:20px;" class="item-row">
                                <div style="line-height:30px;" class="item-label">
                                    Puzzle Splash Page
                                </div>
                                <div style="" class="item-content">								
                                    <input style="width:85%; display:inline-block;margin-right:5%;" value="<?=$site['url']?>splashp/<?=$usr->data->id?>" class="form-control">
                                    <a target="_blank" href="<?=$site['url']?>splashp/<?=$usr->data->id?>"><i style="font-size:20px; top:3px; position:relative;" class="icon-external-link-sign"></i></a>
                                </div>
                             </div>
                            <div style="margin-bottom:20px; padding-bottom:20px;" class="item-row">
                                <div style="line-height:30px;" class="item-label">
                                    Stocks Splash Page
                                </div>
                                <div style="" class="item-content">								
                                    <input style="width:85%; display:inline-block;margin-right:5%;" value="<?=$site['url']?>splashs/<?=$usr->data->id?>" class="form-control">
                                    <a target="_blank" href="<?=$site['url']?>splashs/<?=$usr->data->id?>"><i style="font-size:20px; top:3px; position:relative;" class="icon-external-link-sign"></i></a>
                                </div>
                             </div>
                            <?php } ?>
                            Make sure to enter your profile description in the <a href="<?=$site['url']?>branding">branding game</a>.<br><br>
                            <div style="margin-bottom:20px; padding-bottom:20px;" class="item-row">
                                <div style="line-height:30px;" class="item-label">
                                    Branding Splash Page
                                </div>
                                <div style="" class="item-content">								
                                    <input style="width:85%; display:inline-block;margin-right:5%;" value="<?=$site['url']?>splashb/<?=$usr->data->id?>" class="form-control">
                                    <a target="_blank" href="<?=$site['url']?>splashb/<?=$usr->data->id?>"><i style="font-size:20px; top:3px; position:relative;" class="icon-external-link-sign"></i></a>
                                </div>
                             </div>
                        </center>
                    </div>
                    <div class="tab-pane fade" id="static">
                        <center>
                            <?php if($usr->data->membership != '0001') { ?>
                            <div style="margin-bottom:20px; padding-bottom:20px;" class="item-row">
                                <div style="line-height:30px;" class="item-label">
                                    Cash Give Away!
                                </div>
                                <div style="" class="item-content">								
                                    <input style="width:85%; display:inline-block;margin-right:5%;" value="<?=$site['url']?>splashc/<?=$usr->data->id?>" class="form-control">
                                    <a target="_blank" href="<?=$site['url']?>splashc/<?=$usr->data->id?>"><i style="font-size:20px; top:3px; position:relative;" class="icon-external-link-sign"></i></a>
                                </div>
                             </div>
                            <?php } ?>
                            Enter a tesimonial for the your testimonial splash page. Make sure to make it intriguing!
                        </center>
                        <form method="post">
                            <textarea name="testimonialUpdate"><?=$usr->data->testimonial?></textarea>
                            <center><button type="submit" class="btn btn-primary" style="margin-top:-20px; margin-bottom:20px;">Save</button></center>
                        </form><br>
                        <center>
                            <script>$("textarea").jqte();</script>
                            <div style="margin-bottom:20px; padding-bottom:20px;" class="item-row">
                                <div style="line-height:30px;" class="item-label">
                                    Testimonial Splash Page
                                </div>
                                <div style="" class="item-content">								
                                    <input style="width:85%; display:inline-block;margin-right:5%;" value="<?=$site['url']?>splasht/<?=$usr->data->id?>" class="form-control">
                                    <a target="_blank" href="<?=$site['url']?>splasht/<?=$usr->data->id?>"><i style="font-size:20px; top:3px; position:relative;" class="icon-external-link-sign"></i></a>
                                </div>
                             </div>
                            Enter your YouTube video ID if you would like to change the default:<br><br>
                            <form style="width:500px;" class="input-group" method="post">
                                <span class="input-group-addon">http://youtube.com/watch?v=</span>
                                <input name="splashVideoUpdate" value="<?=$usr->data->splashVideo?>" placeholder="YouTube ID" type="text" class="form-control">
                                <span class="input-group-btn">
                                    <input class="btn btn-primary" type="submit" value="Go!">
                                </span>
                            </form><br>
                            <div style="margin-bottom:20px; padding-bottom:20px;" class="item-row">
                                <div style="line-height:30px;" class="item-label">
                                    Video Splash Page
                                </div>
                                <div style="" class="item-content">								
                                    <input style="width:85%; display:inline-block;margin-right:5%;" value="<?=$site['url']?>splashv/<?=$usr->data->id?>" class="form-control">
                                    <a target="_blank" href="<?=$site['url']?>splashv/<?=$usr->data->id?>"><i style="font-size:20px; top:3px; position:relative;" class="icon-external-link-sign"></i></a>
                                </div>
                             </div>
                            <div style="margin-bottom:20px; padding-bottom:20px;" class="item-row">
                                <div style="line-height:30px;" class="item-label">
                                    Cash Splash Page
                                </div>
                                <div style="" class="item-content">								
                                    <input style="width:85%; display:inline-block;margin-right:5%;" value="<?=$site['url']?>splashm/<?=$usr->data->id?>" class="form-control">
                                    <a target="_blank" href="<?=$site['url']?>splashm/<?=$usr->data->id?>"><i style="font-size:20px; top:3px; position:relative;" class="icon-external-link-sign"></i></a>
                                </div>
                             </div>
                        </center>
                    </div>
                    <div class="tab-pane fade" id="banners">
                        <center>
                            <a target="_blank" href="<?=$site['url']?><?=$usr->data->id?>"><img src="<?=$site['url']?>banner.png"></a><br><br>
                            <div style="margin-bottom:20px; padding-bottom:20px;" class="item-row">
                                <div style="line-height:30px;" class="item-label">
                                    468 x 60 : IMAGE
                                </div>
                                <div style="" class="item-content">								
                                    <input style="width:85%; display:inline-block;margin-right:5%;" value="<?=$site['url']?>banner.png" class="form-control">
                                    <a target="_blank" href="<?=$site['url']?>banner.png"><i style="font-size:20px; top:3px; position:relative;" class="icon-external-link-sign"></i></a>
                                </div>
                             </div>
                            <div style="margin-bottom:20px; padding-bottom:20px;" class="item-row">
                                <div style="line-height:30px;" class="item-label">
                                    468 x 60 : HTML
                                </div>
                                <div style="" class="item-content">					
                                    <input style="width:85%; display:inline-block;margin-right:5%;" value='<a target="_blank" href="<?=$site["url"]?><?=$usr->data->id?>"><img src="<?=$site["url"]?>banner.png"></a>' class="form-control">
                                    <a target="_blank" href="<?=$site['url']?><?=$usr->data->id?>"><i style="font-size:20px; top:3px; position:relative;" class="icon-external-link-sign"></i></a>
                                </div>
                             </div>
                                                                                                                                                                                         
                                                                                                                                                                                         
                            <a target="_blank" href="<?=$site['url']?><?=$usr->data->id?>"><img src="<?=$site['url']?>banner2.png"></a><br><br>
                            <div style="margin-bottom:20px; padding-bottom:20px;" class="item-row">
                                <div style="line-height:30px;" class="item-label">
                                    125 x 125 : IMAGE
                                </div>
                                <div style="" class="item-content">								
                                    <input style="width:85%; display:inline-block;margin-right:5%;" value="<?=$site['url']?>banner2.png" class="form-control">
                                    <a target="_blank" href="<?=$site['url']?>banner2.png"><i style="font-size:20px; top:3px; position:relative;" class="icon-external-link-sign"></i></a>
                                </div>
                             </div>
                            <div style="margin-bottom:20px; padding-bottom:20px;" class="item-row">
                                <div style="line-height:30px;" class="item-label">
                                    125 x 125 : HTML
                                </div>
                                <div style="" class="item-content">					
                                    <input style="width:85%; display:inline-block;margin-right:5%;" value='<a target="_blank" href="<?=$site["url"]?><?=$usr->data->id?>"><img src="<?=$site["url"]?>banner2.png"></a>' class="form-control">
                                    <a target="_blank" href="<?=$site['url']?><?=$usr->data->id?>"><i style="font-size:20px; top:3px; position:relative;" class="icon-external-link-sign"></i></a>
                                </div>
                             </div>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="well">
            <h4>Referral Link</h4>
            <input value="<?=$site['url']?><?=$usr->data->id?>" class="form-control">
        </div>		
        
        <div class="well">
            <h4>How it works</h4>
            <p>We issue payments every Friday through Paypal. You must have a minimum of $15 in your commission balance to recieve the payment, with a 14 day grace period. This means commissions earned won't be paid for 14 days, allowing time for refunds and cheat detection. Make sure to update your Paypal email in the <a href="<?=$site["url"]?>settings">Settings</a>.</p>
        </div>
        
        <div class="well">
            <h4>Earnings</h4>
            Not only will referrals take part in your downline network, but you also currently earn <?=$membership[$usr->data->membership]["refEarnings"] * 100?>% of referral earnings &amp; <?=$membership[$usr->data->membership]["refCommisionPercent"] * 100?>% commissions. Referral earnings include their surfing bonuses, paid to click earnings, and much more coming soon. Earnings for the whole day are added to your account every day at midnight if you remain active. You will earn commissions on upgrades and coin purchases for all your referrals. <a href="<?=$site['url']?>upgrade">Learn more</a>.
        </div>
        <!--<div class="well">
            <h4>How it works</h4>
            <p>You will earn commissions on upgrades and coin purchases for all your referrals. In addition, they will take part in your downline network.</p>
        </div>	-->		
    </div>
</div>
<?php include 'footer.php'; ?>