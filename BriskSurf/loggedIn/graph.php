<?php include 'header.php';

if($getVar)
{
    $website = $db->query("SELECT * FROM `websites` WHERE `id`='{$getVar}' && `status`='1' && `userid`='{$usr->data->id}' LIMIT 1");
    if($website->getNumRows())
    {
        $data = $website->getNext();
        ?>
        <div class="title">My Websites:  <?=$data->name?></div>
        <div class="menu">
            <a href="<?=$site['url']?>view/<?=$getVar?>">Settings</a>
            <a href="<?=$site['url']?>weekday/<?=$getVar?>">Weekday</a>
            <a href="<?=$site['url']?>gender/<?=$getVar?>">Gender</a>
            <a href="<?=$site['url']?>age/<?=$getVar?>">Age</a>
            <a href="<?=$site['url']?>continent/<?=$getVar?>">Continent</a>
            <a style="margin-right:0px;" href="<?=$site['url']?>membership/<?=$getVar?>">Membership</a>
        </div>
        <hr>
        <div class="text">
            Our tracking system is build upon determining interaction with your page. 
            This system is known as <div class="green">IR</div>, standing for <div class="green">interaction rate</div>. 
            IR is out of a maximum of 2 points. A viewer who has an IR of 2 interacted with your website as much as possible.
            <br><br>
            <?php
            $maximum = 0;
            $minimum = 1000;
            $height = 322;
            function getPixels($value, $minimum, $maximum, $height, $margin){
                //if($value > 0 && $minimum < 0) $minimum = 0;
                if($value > $minimum + $margin) $minimum = $minimum + $margin;
                return (($value - $minimum) / $maximum) * $height;
            }
            function getMargin($value, $minimum, $maximum, $height, $margin){
                return $height - getPixels($value, $minimum, $maximum, $height, $margin);
            }
            $results = $db->query("SELECT `{$graphtype}`, COUNT(`IR`) AS `count`, AVG(`IR`) AS `avg` FROM `views` WHERE `siteid` = '{$getVar}' GROUP BY `{$graphtype}`");
            $margins = 0.1;
            $chartrows = [];
            $count = 0;
            while($result = $results->getNext())
            {
                $chartrows[$count]["count"] = $result->count;
                $chartrows[$count]["avg"] = $result->avg;
                $chartrows[$count][$graphtype] = $result->$graphtype;
                if((round($result->avg, 1) + $margins) > $maximum) $maximum = (round($result->avg, 1) + $margins);
                if((round($result->avg, 1) - $margins) < $minimum) $minimum = (round($result->avg, 1) - $margins);
                if($maximum > 2) $maximum = 2;
                if($minimum < 0)
                {
                    $minimum = 0;
                    $margin = 0;
                }
                $count++;
                
            }
            if($count != 0)
            {
            ?>
            <div class='chartbg'>
                <div class="text"><?=$maximum?></div><div class="line"></div>
                <div class="text"><?php echo round((($maximum - $minimum) / 5) * 3 + $minimum, 2); ?></div><div class="line"></div>
                <div class="text"><?php echo round((($maximum - $minimum) / 5) * 2 + $minimum, 2); ?></div><div class="line"></div>
                <div class="text"><?php echo round((($maximum - $minimum) / 5) + $minimum, 2); ?></div><div class="line"></div>
                <div class="text"><?=$minimum?></div><div class="line"></div>
            </div>
            <div class="chart">
            <?php
            for($x = 0; $x < count($chartrows); $x++)
            {
                echo "<div class='chartrow'><div class='charttop charttop{$chartrows[$x][$graphtype]}'></div><div class='chartbottom chartbottom{$chartrows[$x][$graphtype]}'></div></div>";
                echo "<style> .charttop{$chartrows[$x][$graphtype]}{ height:" . getMargin($chartrows[$x]["avg"], $minimum, $maximum, $height, $margin) . "px; } .chartbottom{$chartrows[$x][$graphtype]}{ height:" . getPixels($chartrows[$x]["avg"], $minimum, $maximum, $height, $margin) . "px} </style>";
                
            }
            $width = 100 / $count - 11;
            echo "<style>.chartrow{ width:{$width}%; }</style></div><br><br>";
            }
            else
            {
                echo "Graph is unavailable. You must get some views to your website before you can see some graphs";
            }
            ?>
            
            <?php
            $arrayResult = $arrayManager->getCategory($vars, $variableName);
            for($x = 0; $x < count($chartrows); $x++)
            {
                echo "<div class='chartrow charttext'>" . $arrayResult[$chartrows[$x][$graphtype]] . "<br>" . $chartrows[$x]["count"] .  " view";
                if($chartrows[$x]["count"] != 1) echo "s";
                echo " </div>";
                
            }
            ?>
            <br>
            <br>
            <div class="subtitle">Filters</div>
            <?php if($graphtype == "membership" && $usr->data->membership == "0001") echo "You must be an upgraded member to filter the membership audience";
            else
            {
                ?>
                According to our research, your interaction rate will <div class="red">increase significantly</div> 
                when you filter your website to display to the right audience
                <br><br>
                <div class="filter">
                    <div class="filterred">Disabled</div>
                    <div class="filtergreen">Enabled</div>
                </div>
                <br>
                <div class="filters">
                <?php
                
                foreach ($arrayResult as $key => $value)
                {
                    if($key != 0)
                    {
                        if (strpos($data->exceptions, $key) !== false) echo "<div name='{$key}' class='filterred'>{$value}</div>";
                        else echo "<div name='{$key}' class='filtergreen'>{$value}</div>";
                    }
                }
                ?>
                </div>
                <script>
                    $(".filters div").click(function () {
                        $(this).toggleClass("filtergreen");
                        $(this).toggleClass("filterred");
                    });    
                </script>
                <br>
                <div class="form">
                    <input id="updateFiltersSubmit" type="submit" value='Update Filters'/>
                </div>
                
                <div class="loading"><br></div>
                <script>
                    $("#updateFiltersSubmit").click(function()
                    {
                        loading("<br>Your filters are being updated");
                        data = {"id": '<?=$getVar?>', "filters": {}}
                        $( ".filters div" ).each(function() {
                            console.log();
                            data["filters"][$(this).attr("name")] = ($(this).hasClass("filtergreen")) ? true : false;
                        });
                        var data_encoded = JSON.stringify(data);
                        $.ajax({
                            type: "POST",
                            url: "<?=$site['url']?>loggedIn/updateFilters.php",
                            dataType: "json",
                            data: {
                                "data" : data_encoded
                            },
                            success: function(data) {
                                if(!data.loggedIn)
                                {
                                    changeText("<br><div class='error'>ERROR: You must login. Click <a href='<?=$site['url']?>'>here</a> to continue</div>");
                                }
                                else if(data.error)
                                {
                                    changeText("<br><div class='error'>ERROR: " + data.error + "</div>");
                                }
                                else
                                {
                                    changeText("<br><div class='success'>The filters have been updated</div>");
                                }
                            },
                            error: function(data)
                            {
                                console.log(data);
                            }
                        });
                    });
                    function loading(text)
                    {
                        changeText(text + "<br><img src='<?=$site["url"]?>loggedIn/images/whiteLoader.gif'/>");
                    }
                    
                    function changeText(text)
                    {
                        $("#content .content .loading").html(text);
                    }
                </script>
                <?php } ?>
        </div>
    <?php
    }
    else echo 'ERROR: An error has occured';
}
else echo 'ERROR: An error has occured';

include 'footer.php'; ?>