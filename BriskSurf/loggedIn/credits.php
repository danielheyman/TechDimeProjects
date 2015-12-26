<?php include 'header.php'; ?>
<div class="title">Buy Credits</div>
<hr>
<div class="text">
    
    <?php

    $query = $db->query("SELECT `id`, `sale`, UNIX_TIMESTAMP(`end`) - UNIX_TIMESTAMP(NOW()) AS `end`, `count`, `display`, `text` FROM `sales` WHERE `end` > NOW() &&  `start` < NOW() && `count` > 0");
    $sale = false;
    if($query->getNumRows())
    {
        $query = $query->getNext();
        $saleID = $query->id;
        $sale = $query->sale;
        $display = '';
        if($query->display == '1') $display = "Only {$query->count} packages left.";
        else if($query->display == '2') $display = "Only " . $gui->timeFormat($query->end) . ' left.';
        ?>
        <div class="promo"><?=$query->text?> <strong><?=$display?></strong></div>
        <?php
    }
    foreach ($packages as $key => $value)
    {
        if($value["type"] == "credit" && $value["status"] == 1)
        {
            $price = ($sale) ? ceil($value["price"] * (100 - $sale)) / 100 : $value["price"];
            ?>
            <div class="creditBox form <?php //echo sale ?>">
                <?=number_format($value["value"])?> credits - <?=($sale) ? "<strike>$" . $value["price"] . "</strike><br><div style='color:#87b24d; line-height:15px; padding:0; margin-bottom:15px;'>Now only $" . $price . '</div>': "$" . $price?>
                <form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_xclick">
                    <input type="hidden" name="amount" value="<?=$price?>">
                    <input type="hidden" name="rm" value="1">
                    <input type="hidden" name="no_note" value="1">
                    <input type="hidden" name="no_shipping" value="1">
                    <input type="hidden" name="business" value="<?=$site["paypal"]?>">
                    <input type="hidden" name="currency_code" value="USD">
                    <input type="hidden" name="item_name" value="<?=number_format($value["value"])?> <?=$site["name"]?> Credits">
                    <input type="hidden" name="item_number" value="<?=$key?>">
                    <input type="hidden" name="notify_url" value="<?=$site["url"]?>ipn.php">
                    <input type="hidden" name="custom" value='<?=$usr->data->id?><?php if($sale) echo "-s-{$saleID}"; ?>'>
                    <input type="hidden" name="cancel_return" value="<?=$site["url"]?>">
                    <input type="hidden" name="return" value="<?=$site["url"]?>success/">
                    <input type="submit" value='Purchase' name="submit">
                </form> 
            </div>
            <?php
        }
    }
    ?>
    <style>
        .creditBox.sale
        {
            background:#87b24d!important;   
        }
    </style>
</div>
<?php include 'footer.php'; ?>