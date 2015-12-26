<?php include 'header.php'; ?>
<div class="row">
    <div class="col-md-12">
        <div class="widget stacked">
            <div class="widget-header">
                <i class="icon-book"></i>
                <h3>Tutorial</h3>
            </div>
            <div class="widget-content">
                <ul class="nav nav-tabs">
                    <?php
                    $options = $db->query("SELECT `id`, `title` FROM `videoCat`");
                    $count = 0;
                    while($option = $options->getNext())
                    {
                        $selected = ($option->id == $getVar) ? "active " : "";
                        echo "<li class='{$selected}'><a href='{$site['url']}tutorials/{$option->id}'>{$option->title}</a></li>";
                        $count++;
                    }
                    ?>
                </ul>
                
                <!--<center><h5 style="line-height: 20px;">
                Categories: &nbsp; 
                <?php
                $options = $db->query("SELECT `id`, `title` FROM `videoCat`");
                $count = 0;
                while($option = $options->getNext())
                {
                    if($count != 0) echo ' | ';
                    $selected = ($option->id == $getVar) ? "selected " : "";
                    echo "<a href='{$site['url']}tutorials/{$option->id}'>{$option->title}</a>";
                    $count++;
                }
                ?>
                <br></h5></center>-->
                
                <!--<select id="selectStock" class="form-control">
                    <option value="0">Select a Series</option>
                    <?php
                    $options = $db->query("SELECT `id`, `title` FROM `videoCat`");
                    while($option = $options->getNext())
                    {
                        $selected = ($option->id == $getVar) ? "selected " : "";
                        echo "<option {$selected}value='{$option->id}'>{$option->title}</option>";
                    }
                    ?>
                    <script>
                    $("#selectStock").change(function()
                    {
                        var value = $("#selectStock").val();
                        window.location = "<?=$site['url']?>tutorials/" + value;
                    });
                    </script>
                </select>-->
                <?php 
                if($getVar) $videos = $db->query("SELECT `creator`, `id`, `title` FROM `videos` WHERE `catid` = '{$getVar}'");
                if($getVar && $videos->getNumRows())
                {
                    ?>
                    <style>
                        .thumbs img
                        {
                            width: 180px;
                            -moz-border-radius: 5px;
                            -o-border-radius: 5px;
                            -webkit-border-radius: 5px;
                            border-radius: 5px;
                            margin: 10px;
                            -moz-box-shadow: 0 0 5px #454545;
                            -o-box-shadow: 0 0 5px #454545;
                            -webkit-box-shadow: 0 0 5px #454545;
                            box-shadow: 0 0 5px #454545;
                        }
                        
                        .thumbs
                        {
                            background:#E9E9E9;
                            border-radius:5px;
                            display:inline-block;
                            padding:10px;
                            text-align:center;
                            text-decoration:none;
                            color:#555;
                            margin-right:10px;
                            margin-left:10px;
                            margin-bottom: 20px;
                        }
                        
                        .complete{
                            background:#59d167;
                            color:#fff;
                        }
                        
                        .thumbs:hover{
                            background:#F90;
                            color:#fff;
                            text-decoration:none;
                        }
                    </style>
                    <br>
                    <center>
                    <?php
                    while($video = $videos->getNext())
                    {
                        $test = $db->query("SELECT `id` FROM `videoCompletes` WHERE `userid` = '{$usr->data->id}' && `videoid` = '{$video->id}'");
                        $complete = ($test->getNumRows()) ? " complete" : "";
                        echo "<a class='thumbs{$complete}' href='{$site['url']}video/{$video->id}'>{$video->title}<br><img src='{$site['url']}videoThumbs/{$video->id}.png'><br>Producer: {$video->creator}</a>";
                    }
                    echo "</center>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>