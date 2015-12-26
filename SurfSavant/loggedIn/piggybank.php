<?php include 'header.php'; ?>
<div class="row">
    <div class="col-md-8">
        <div class="widget stacked">
            <div class="widget-header">
                <i class="icon-shopping-cart"></i>
                <h3>Piggybank</h3>
            </div>
            <div class="widget-content">
                <center>
                    <?php
                    if($sec->post('newPaypalInput'))
                    {
                        $amount = $sec->post('newPaypalInput');
                        if(is_numeric($amount) && $amount >= 5)
                        {
                            echo "<b>Click on the button to complete your order for $" . $amount . ".</b>";
                            ?>
                                <br><br>
                                <form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                                    <input type="hidden" name="cmd" value="_xclick">
                                    <input type="hidden" name="amount" value="<?=$amount?>">
                                    <input type="hidden" name="rm" value="1">
                                    <input type="hidden" name="no_note" value="1">
                                    <input type="hidden" name="no_shipping" value="1">
                                    <input type="hidden" name="business" value="<?=$site["paypal"]?>">
                                    <input type="hidden" name="currency_code" value="USD">
                                    <input type="hidden" name="item_name" value="$<?=$amount?> for <?=$site["name"]?> Piggybank">
                                    <input type="hidden" name="item_number" value="99999">
                                    <input type="hidden" name="notify_url" value="<?=$site["url"]?>ipn.php">
                                    <input type="hidden" name="custom" value="<?=$usr->data->id?>">
                                    <input type="hidden" name="cancel_return" value="<?=$site["url"]?>">
                                    <input type="hidden" name="return" value="<?=$site["url"]?>success/">
                                    <input type="submit" value='Purchase' name="submit" class="btn btn-primary">
                                </form>	
                            <?php
                        }
                        else echo "<b>You have not entered the minimum value of $5.00.</b>";
                        echo "<hr>";
                    }
                    else if($sec->post('newCashInput'))
                    {
                        $amount = $sec->post('newCashInput');
                        if(is_numeric($amount) && $amount >= 1)
                        {
                            $result = $db->query("SELECT SUM(`amount`) AS `sum` FROM `commissions` WHERE `status` = '1' && `userid` = '{$usr->data->id}'");
                            $sum = $result->getNext()->sum;
                            if($sum >= $amount)
                            {
                                $db->query("UPDATE `users` SET `piggybank` = `piggybank` + {$amount} WHERE `id`='{$usr->data->id}'");
                                
                                $item_name = 'Transfer $' . $amount . ' to Piggybank';
                                $db->query("INSERT INTO `transactions` (`id`, `userid`, `item_number`, `item_name`, `txn_id`, `amount`, `date`) VALUES (NULL, '{$usr->data->id}', '99999', '{$item_name}', '', '0', CURRENT_TIMESTAMP)");   
                                $id = $db->insertID;
                                $earn = $amount * -1;
                                $db->query("INSERT INTO `commissions` (`id`, `userid`, `transactionid`, `amount`, `status`) VALUES (NULL, '{$usr->data->id}', '{$id}', '{$earn}', '1')"); 
                                echo "<script>window.location = '{$site['url']}piggybank/c'</script>";
                                exit;
                            }
                            else echo "<b>You do not have enough funds in your account.</b>";
                        }
                        else echo "<b>You have not entered the minimum value of $5.00.</b>";
                        echo "<hr>";
                    }
                    else if($getVar == 'c')
                    {
                         echo "<b>The cash has been converted.</b><hr>";  
                    }
                    ?>
                    <h3>Paypal Method</h3>
                    You can enter an amount below to add to your piggybank from Paypal.<br>The minimum order is $5.00.<br><br>
                    <form method="post" action="<?=$site['url']?>piggybank">
                        <div style="width:500px;" class="input-group">
                            <span class="input-group-addon">$</span>
                            <input name="newPaypalInput" placeholder="Cash Value to Add" type="text" class="form-control">
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">Add</button>
                            </span>
                        </div>
                    </form>
                    <br><br>
                    <h3>Surf Savant Cash Coversion Method</h3>
                    You can enter an amount below to add to your piggybank from your cash prizes &amp; commissions.<br>The minimum transfer is $1.00 (You have $<?php echo $db->query("SELECT SUM(`amount`) AS `sum` FROM `commissions` WHERE `status` = '1' && `userid` = '{$usr->data->id}'")->getNext()->sum; ?>). Cannot be converted back.<br><br>
                    <form id="newCashForm" method="post" action="<?=$site['url']?>piggybank">
                        <input type="hidden" id="newCashFinal" name="newCashInput">
                    </form>
                    <div style="width:500px;" class="input-group">
                        <span class="input-group-addon">$</span>
                        <input id="newCashInput" name="newCashInput" placeholder="Cash Value to Add" type="text" class="form-control">
                        <span class="input-group-btn">
                            <button id="newCashSubmit" class="btn btn-primary">Add</button>
                        </span>
                    </div>
                    
                    <script>
                    $("#newCashSubmit").click(function()
                    {
                        var count = $("#newCashInput").val();
                        if(count >= 1)
                        {
                            $.msgbox("Are you sure you want to convert $" + count + "  from your commissions and cash prizes into your piggbank? It cannot be reversed.", {
                              type: "confirm",
                              buttons : [
                                {type: "submit", value: "Yes"},
                                {type: "submit", value: "No"}
                              ]
                            }, function(result) {
                                if(result == "Yes")
                                {
                                    $("#newCashFinal").val(count);
                                    $("#newCashForm").submit();
                                }
                            });
                        }
                        else
                        {
                            $.msgbox("Invalid value entered.", {
                              type: "error"
                            });
                        }
                    });
                    </script>
                    <br><br>
                    <b>Transaction History</b><br><br>
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Method</th>
                                <th>Amount Added</th>
                            </tr>
                        </thead>
                        <?php
                        $transactions = $db->query("SELECT `date`, `amount`, 'Paypal' AS `method` FROM `transactions` WHERE `userid` = '{$usr->data->id}' && `item_number` = '99999' && `amount` > 0 UNION ALL SELECT `date`, (SELECT `amount` * -1 FROM `commissions` WHERE `transactionid` = `transactions`.`id`) AS `amount`, 'Cash Conversion' AS `method` FROM `transactions` WHERE `userid` = '{$usr->data->id}' && `item_number` = '99999' && `amount` = 0 ORDER BY `date` DESC");
                        if($transactions->getNumRows())
                        {
                            while($transaction = $transactions->getNext())
                            {
                                ?>
                                <tr>
                                    <td><?=$transaction->date?></td>
                                    <td><?=$transaction->method?></td>
                                    <td>$<?=$transaction->amount?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </table>
                </center>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="well">
            <h4>Piggybank</h4>
            <p>You have <b>$<?=$usr->data->piggybank?></b> in your piggybank.</p>
        </div>			
        <div class="well">
            <h4>How it works</h4>
            <p>The piggybank is used to store cash that can be used for on-site purchases other than coins or an upgrade. This currently includes the PTC game feature and the activity website bidding, with much more coming soon.</p>
        </div>			
    </div>
</div>
<?php include 'footer.php'; ?>