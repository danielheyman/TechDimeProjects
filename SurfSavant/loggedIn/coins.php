<?php include 'header.php'; ?>
<link href="<?=$site["url"]?>res/css/pages/plans.css" rel="stylesheet"> 
<link href="<?=$site["url"]?>res/css/pages/pricing.css" rel="stylesheet"> 
<div class="row">
    <div class="col-md-12">
        <div class="widget stacked">
                
            <div class="widget-header">
                <i class="icon-compass"></i>
                <h3>Coin Packages</h3>
            </div>
            <div class="widget-content">
                <center>
                    <div class="pricing-plans plans-4">
                        <?php
                        $query = $db->query("SELECT `id`, `sale` FROM `sales` WHERE `end` > NOW() &&  `start` < NOW() && `count` > 0");
                        $sale = false;
                        if($query->getNumRows())
                        {
                            $query = $query->getNext();
                            $saleID = $query->id;
                            $sale = $query->sale;
                        }
                        foreach ($packages as $key => $value)
                        {
                            if($value["type"] == "coin")
                            {
                                $price = ($sale) ? ceil($value["price"] * (100 - $sale)) / 100 : $value["price"];
                                ?>
                                <div style="display:inline-block; width:300px; margin-bottom:20px;">
                                    <div class="plan stacked">
                                        <div class="plan-header">
                                            <div class="plan-title">
                                                <?=($sale) ? "<strike>$" . $value["price"] . "</strike><br><div style='color:#F90;'>$" . $price . '</div>': "$" . $price?>	        		
                                            </div>
                                            <div class="plan-price">
                                                <?=number_format($value["value"])?><span class="term">Coins</span>
                                            </div>
                                        </div>
                                        <div class="plan-actions">	
                                            <form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                                                <input type="hidden" name="cmd" value="_xclick">
                                                <input type="hidden" name="amount" value="<?=$price?>">
                                                <input type="hidden" name="rm" value="1">
                                                <input type="hidden" name="no_note" value="1">
                                                <input type="hidden" name="no_shipping" value="1">
                                                <input type="hidden" name="business" value="<?=$site["paypal"]?>">
                                                <input type="hidden" name="currency_code" value="USD">
                                                <input type="hidden" name="item_name" value="<?=number_format($value["value"])?> <?=$site["name"]?> Coins">
                                                <input type="hidden" name="item_number" value="<?=$key?>">
                                                <input type="hidden" name="notify_url" value="<?=$site["url"]?>ipn.php">
                                                <input type="hidden" name="custom" value='<?=$usr->data->id?><?php if($sale) echo "-s-{$saleID}"; ?>'>
                                                <input type="hidden" name="cancel_return" value="<?=$site["url"]?>">
                                                <input type="hidden" name="return" value="<?=$site["url"]?>success/">
                                                <input style="width: 80%; margin:auto;" type="submit" value='Purchase' name="submit" class="btn btn-default">
                                            </form>	
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </center>
            </div>
        </div>
    </div>
  </div>
<?php include 'footer.php';?>