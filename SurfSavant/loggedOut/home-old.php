<?php include 'header.php'; ?>
<div class="row">
    <div class="col-md-12">
        <!--<div class="widget stacked">
            <div style="width:100%; height:100px; background:#F90; color:#fff; line-height:100px; text-align:center; font-size:35px;"><i class="icon-lightbulb"></i> Learn to Succeed &nbsp; <i class="icon-money"></i> Make Money &nbsp; <i class="icon-thumbs-up"></i> Have Fun!</div> 
        </div>
        <div class="well" style="background:#F90; color:#fff; text-align:center; font-size:27px; line-height:35px;">-->
            
        <div class="well" style="background: #F8F8F8;
color: #2f3840;
text-align: center;
font-size: 27px;
line-height: 35px;
background: #E9E9E9;
background: -moz-linear-gradient(top, #FAFAFA 0%, #E9E9E9 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#FAFAFA), color-stop(100%,#E9E9E9));
background: -webkit-linear-gradient(top, #FAFAFA 0%,#E9E9E9 100%);
background: -o-linear-gradient(top, #FAFAFA 0%,#E9E9E9 100%);
background: -ms-linear-gradient(top, #FAFAFA 0%,#E9E9E9 100%);
background: linear-gradient(top, #FAFAFA 0%,#E9E9E9 100%);
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#FAFAFA', endColorstr='#E9E9E9');
-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr='#FAFAFA', endColorstr='#E9E9E9')";">
            <i class="icon-lightbulb"></i> Learn to Succeed &nbsp; <i class="icon-money"></i> Make Money &nbsp; <i class="icon-thumbs-up"></i> Have Fun!
        </div>
    </div>
    <div class="col-md-6">
        
        <div class="widget big-stats-container stacked">
            <div class="widget-content">
                <div id="big_stats" class="cf">
                    <div class="stat">								
                        <h4>Total Users</h4>
                        <span class="value"><?php echo number_format($db->query("SELECT COUNT(`id`) as `count` FROM `users` WHERE `activation` = 1")->getNext()->count); ?></span>								
                    </div>
                    <!--<div class="stat">								
                        <h4>Registered Today</h4>
                        <span class="value"><?php echo number_format($db->query("SELECT COUNT(`id`) as `count` FROM `users` WHERE DATE(`registerDate`) = DATE(NOW()) && `activation` = 1")->getNext()->count); ?></span>								
                    </div>-->
                    <div class="stat">								
                        <h4>Total Paid Out</h4>
                        <span class="value">$<?php echo number_format($db->query("SELECT SUM(`amount`) as `count` FROM `commissions` WHERE `status` = '0'")->getNext()->count,2); ?></span>								
                    </div>
                </div>
            </div>
        </div>
        <div class="widget stacked">
            <div class="widget-header">
                <i class="icon-question-sign"></i>
                <h3>What is Surf Savant?</h3>
            </div>
            <div class="widget-content">
                <p>Surf Savant is a finely tuned learning tool for anyone who wants to build an online business. It’s a smart system to grow your downlines and your earning potential. We also do our best to make this experience as fun and effortless as possible.</p>
            </div>
        </div>
        <div class="widget stacked">
            <div class="widget-header">
                <i class="icon-money"></i>
                <h3>Make Money at Surf Savant</h3>
            </div>
            <div class="widget-content">
                <p>Of course you can make money as a Surf Savant. We've got prizes and contests with a huge amount of opportunities to win cash. In addition, you can also promote our awesome tool, and you earn commissions for others' purchases.</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        
        
        <div class="widget stacked widget-table action-table">
            <div class="widget-header">
                <i class="icon-trophy"></i>
                <h3>Recent Winners</h3>
            </div>
            <div class="widget-content">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $query = $db->query("SELECT `amount`, TIME_TO_SEC(TIMEDIFF(NOW(), (SELECT `date` FROM `transactions` WHERE `transactions`.`id` = `commissions`.`transactionid`))) AS `time`, (SELECT `fullName` FROM `users` WHERE `users`.`id` = `commissions`.`userid`) AS `name` FROM `commissions` ORDER BY ID DESC LIMIT 5");
                            while($prize = $query->getNext())
                            {
                                $name = explode(" ", $prize->name)[0];
                                $secondsInAMinute = 60;
                                $secondsInAnHour  = 60 * $secondsInAMinute;
                                $secondsInADay    = 24 * $secondsInAnHour;
                            
                                // extract days
                                $days = floor($prize->time / $secondsInADay);
                            
                                // extract hours
                                $hourSeconds = $prize->time % $secondsInADay;
                                $hours = floor($hourSeconds / $secondsInAnHour);
                            
                                // extract minutes
                                $minuteSeconds = $hourSeconds % $secondsInAnHour;
                                $minutes = floor($minuteSeconds / $secondsInAMinute);
                            
                                // extract the remaining seconds
                                $remainingSeconds = $minuteSeconds % $secondsInAMinute;
                                $seconds = ceil($remainingSeconds);
                                
                                
                                if($days != 0) $time = $days . " days";
                                else if($hours != 0) $time = $hours . " hours";
                                else if($minutes != 0) $time = $minutes . " minutes";
                                else $time = $seconds . " seconds";
                                    
                                
                                echo "<tr><td>{$name}</td><td>$" . $prize->amount . "</td><td>{$time}</td></tr>";
                            }
                        ?>
                        </tbody>
                    </table>
            </div>
        </div>
        <div class="widget stacked">
            <div class="widget-content">
                <p><i>"Don't judge each day by the harvest you reap but by the seeds that you plant."</i></p>
                <p style="float:right; margin-right:20px;">-- Robert Louis Stevenson</p>
            </div>
        </div>
        <div class="widget stacked">
            <div class="widget-header">
                <i class="icon-thumbs-up"></i>
                <h3>Mission Statement</h3>
            </div>
            <div class="widget-content">
                <p>We want to help our members build a stronger presence online and ensure that the time they spend doing it is more productive, efficient and fun.</p>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>