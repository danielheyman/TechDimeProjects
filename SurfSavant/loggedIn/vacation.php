<?php include 'header.php'; ?>
<div class="row">
    <?php
        if($sec->post("vacationInput"))
        {
            $count = $sec->post("vacationInput");
            $coins = $count * 100;
            if(is_numeric($count) && $count >= 0)
            {
                if($usr->data->coins >= $coins)
                {
                    $db->query("UPDATE `users` SET `coins` = `coins` - {$coins}, `vacations` = `vacations` + {$count} WHERE `id` = '{$usr->data->id}'");
                    ?>
                    <div class="col-md-12">
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Well done!</strong> The vacation days have been added.
                        </div>
                    </div>
                    <?php
                    $usr->getData();
                }
                else
                {
                    ?>
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <strong>Oops!</strong> You do not have enough coins.
                        </div>
                    </div>
                    <?php
                }
            }
            else
            {
                ?>
                <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>Oops!</strong> You have entered an invalid vacation count.
                    </div>
                </div>
                <?php
            }
        }
        
    ?>
    <div class="col-md-8">
        <div class="widget stacked">
            <div class="widget-header">
                <i class="icon-rocket"></i>
                <h3>Vacation</h3>
            </div>
            <div class="widget-content">
                <center>
                    <form id="vacationForm" method="post">
                        <div style="width:500px;" class="input-group">
                            <span class="input-group-addon">#</span>
                            <input id="vacationInput" name="vacationInput" placeholder="Vacation Days" type="text" class="form-control">
                            <span class="input-group-btn">
                                <button id="vacationSubmit" class="btn btn-primary" type="button">Buy</button>
                            </span>
                        </div>
                    </form>
                </center>
                <script>
                $("#vacationSubmit").click(function()
                {
                    var count = $("#vacationInput").val();
                    var price = count * 100;
                    if(price != 0)
                    {
                        $.msgbox("You have <?=$usr->data->coins?> coins. Are you sure you want to buy " + count + " vacation days for " + price + " coins?", {
                          type: "confirm",
                          buttons : [
                            {type: "submit", value: "Yes"},
                            {type: "submit", value: "No"}
                          ]
                        }, function(result) {
                            if(result == "Yes")
                            {
                                $("#vacationForm").submit();
                            }
                        });
                    }
                });
                </script>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="well">
            <h4>Vacation Count</h4>
            You have <?=$usr->data->vacations?> vacation days.
        </div>	
        <div class="well">
            <h4>How it works</h4>
            <p>When you have vacation days, you can skip a day, and you will still gain XP and all the other benefits of being active. Each vacation day costs 100 coins.</p>
        </div>					
    </div>
</div>
<?php include 'footer.php'; ?>