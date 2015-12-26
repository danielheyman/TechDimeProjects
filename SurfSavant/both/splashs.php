<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Surf Savant</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">    
    
    <link href="<?=$site["url"]?>res/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=$site["url"]?>res/css/bootstrap-responsive.min.css" rel="stylesheet">
    
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="<?=$site["url"]?>res/css/font-awesome.min.css" rel="stylesheet">        
    
    <link href="<?=$site["url"]?>res/css/base-admin-3.css" rel="stylesheet">
    <link href="<?=$site["url"]?>res/css/base-admin-3-responsive.css" rel="stylesheet">
      
    <link href="<?=$site["url"]?>res/css/base-admin-tweaks.css" rel="stylesheet">

      
    <script src="<?=$site["url"]?>res/jquery-1.7.min.js"></script>
      <script src="<?=$site["url"]?>res/js/plugins/flot/jquery.flot.js"></script>
      <script src="<?=$site["url"]?>res/js/plugins/flot/jquery.flot.resize.js"></script>

  </head>

<body>

    
<nav class="navbar navbar-inverse" role="navigation">

	<div class="container">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Toggle navigation</span>
      <i class="icon-cog"></i>
    </button>
    <a target="_blank" class="navbar-brand" href="<?=$site["url"]?><?=$getVar?>"><!--<i class="icon-shield"></i> &nbsp;<?=$site["name"]?>-->&nbsp;</a>
  </div>
</div> <!-- /.container -->
</nav>
    
<br>
    
    
<div class="main">
    <div class="container"> 
        <div class="row">
            <div class="col-md-12">
                <div class="widget stacked">
                <div class="widget stacked">
                    <div class="widget-content">
                        <style>
                            h2{
                                margin-top: 20px;
                                margin-bottom: 30px;
                                font-size: 24px;
                                font-weight: 600;   
                            }
                            h3 img{
                                margin-bottom: 30px;  
                            }
                            h3{
                                font-size: 18px;
                                font-weight: 400;
                                color: #777;   
                            }
                            
                            #getin{
                                padding: 10px 20px;
                                font-size: 20px;
                            }
                        </style>
                        <?php
                            $stock = $db->query("SELECT `code` FROM `uniqueHits` GROUP BY `code` HAVING COUNT(`code`) > 14 ORDER BY RAND() LIMIT 1");
                            $stock = $stock->getNext();
                            $info = $db->query("SELECT `name` FROM `stockSites` WHERE `code` = '{$stock->code}'");
                            $info = $info->getNext();
                            echo "<center><!--<h2><i class='icon-shield'></i> Surf Savant</h2>--><h3>{$info->name} Traffic Exchange Stocks</h3></center><br>";

                            $query = $db->query("SELECT `worth` FROM `uniqueHits` WHERE `code` = '{$stock->code}' && `worth` != 0 ORDER BY `id` ASC LIMIT 14");
                            $lowest = 999;
                            $last = 0;
                            $string = "";
                            $count = 0;
                            $day = 0;
                            while($point = $query->getNext()) 
                            {
                                if($count != 0) $string .= ",";
                                $string .= $point->worth;
                                if(($point->worth < $lowest) && ($count < 7)) 
                                {
                                    $day = $count;
                                    $lowest = $point->worth;
                                }
                                if($count == 13) $last = $point->worth;
                                $count++;
                            }
                            if($lowest > $last) {
                                $day = 0;
                                $lowest = $last - rand(37,299) / 100;
                                $string = explode(",", $string);
                                $string[0] = $lowest;
                                $string = implode(",", $string);
                            }
                            
                        ?>
                        <center>
                            <div style="max-width:500px;" class="input-group">
                                <span class="input-group-addon">#</span>
                                <input id="stockInput" placeholder="Enter any # of stocks to invest" type="text" class="form-control">
                                <span class="input-group-btn">
                                    <button id="stockSubmit" class="btn btn-primary" type="button">Invest</button>
                                </span>
                            </div>
                        </center><br>
                        <div id="area-chart" class="chart-holder"></div>
                        <center><br><h3><div id="bought" style="color:#c54545; display:none;'">You invested 100 coins</div></h3><h3><div id="sold" style="color:#87b24d; display:none;">You sold for 120 coins</div></h3><h3><div id="won" style="display:none;">If you invested 14 days ago, you would have won 20 coins!</div></h3><br><a target="_blank" href='<?=$site["url"]?><?=$getVar?>'><button type='button' class='btn btn-primary' id='getin'>Get in the Game!</button></a></center>
                        <script>
                        $(function () {
                            
                            $("#stockSubmit").click(function()
                            {
                                var count = $("#stockInput").val();
                                if(isNaN(count) || count <= 0) count = 10;
                                var bought = Math.round(count * <?=$lowest?> * 100) / 100;
                                var sold = Math.round(count * <?=$last?> * 100) / 100;
                                var day = 14 - <?=$day?>;
                                var diff = (Math.round((sold - bought)*100)/100);
                                $("#bought").html("You invested " + bought + " coins");
                                $("#sold").html("You sold for " + sold + " coins");
                                $("#won").html("If you invested in <?=$info->name?> " + day + " days ago, you would have earned " + diff + " coins");
                                $("#bought").slideDown(function() {
                                    update();
                                    setTimeout(function() {
                                        $("#sold").slideDown(function() {
                                            setTimeout(function() {
                                                $("#won").slideDown();
                                            },500);
                                        });
                                    },30 * (day * 24 - 100) - 100);
                                });
                            });
                            
                            var points = [
                            <?=$string?>];
                            var found = <?=$day?>;
                            var data = [], totalPoints = 24 * 13 + 1;
                            
                            
                            var min = 99999;
                            var max = 0;
                            for(var x = found * 24; x < totalPoints; x++)
                            {
                                if(points[(x) / 24] < min) min = points[(x) / 24];
                                if(points[(x) / 24] > max) max = points[(x) / 24];
                            }
                            var variation = (max - min) / 10;
                            
                            
                            for(var x = found * 24; x < totalPoints; x++)
                            {
                                if(x % 24 != 0)
                                {
                                    var before = points[(x - (x % 24)) / 24];
                                    var after = points[((x + 24) - ((x + 24) % 24)) / 24];
                                    var slope = (after - before) / 24;
                                    data.push(before + slope * (x % 24) + (Math.random()*variation - variation / 2));
                                }
                                else data.push(points[(x) / 24]);
                            }
                            count = 0;
                            function getRandomData() {
                    
                                
                                var res = [];
                                for (var i = count; i < count + 100; ++i) {
                                    res.push([i - count, data[i]])
                                }
                                if(count < totalPoints - found * 24 - 100) count++;
                                $("#count").html(Math.floor(res[99][1]*100)/100);
                                return res;
                            }
                    
                            // Set up the control widget
                    
                            var updateInterval = 30;
                    
                            var plot = $.plot("#area-chart", [ getRandomData() ], {
                                series: {
                                    shadowSize: 0	// Drawing is faster without shadows
                                },
                                yaxis: {
                                    min: 0,
                                    max: max * 1.05
                                },
                                xaxis: {
                                    show: false
                                },
                                colors: ["#F90", "#222", "#666", "#BBB"],
                            series: {
                                       lines: { 
                                            lineWidth: 2, 
                                            fill: true,
                                            fillColor: { colors: [ { opacity: 0.6 }, { opacity: 0.2 } ] },
                                            steps: false,
                                        }
                                   }
                            });
                            plot.setData([getRandomData()]);
                            function update() {
                    
                                plot.setData([getRandomData()]);
                    
                                // Since the axes don't change, we don't need to call plot.setupGrid()
                    
                                plot.draw();
                                setTimeout(update, updateInterval);
                            }
                        });
                    </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>