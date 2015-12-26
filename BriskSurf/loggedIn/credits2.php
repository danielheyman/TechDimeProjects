<?php include 'header.php'; ?>
<?php $subscription = [10,11,12,13,14]; //$subscription = [22,10,11,12,13,14]; ?>
<?php $sale = [0,0,0,0,0]; //$sale = [1,0,0,0,0,0]; ?>
<div class="title">Buy Credits</div>
<hr>
<div class="text">
    
    <?php
    foreach ($subscription as $key2 => $value)
    {
        $key = $value;
        $value = $subscriptions[$key];
        ?>
        <div class="creditBox form<?php if($sale[$key2]) echo ' sale'; ?>">
            <?=number_format($value["credits"])?> credits - $<?=$value["price"]?><br>
            <form name="_xclick" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
                <input type="hidden" name="cmd" value="_xclick">
                <input type="hidden" name="amount" value="<?=$value["price"]?>">
                <input type="hidden" name="rm" value="1">
                <input type="hidden" name="no_note" value="1">
                <input type="hidden" name="no_shipping" value="1">
                <input type="hidden" name="business" value="payments-facilitator@techdime.com">
                <input type="hidden" name="currency_code" value="USD">
                <input type="hidden" name="item_name" value="<?=number_format($value["credits"])?> <?=$site["name"]?> Credits">
                <input type="hidden" name="item_number" value="<?=$key?>">
                <input type="hidden" name="notify_url" value="<?=$site["url"]?>ipn.php">
                <input type="hidden" name="custom" value="<?=$usr->data->id?>">
                <input type="hidden" name="cancel_return" value="<?=$site["url"]?>">
                <input type="hidden" name="return" value="<?=$site["url"]?>success/">
                <input type="submit" value='Purchase' name="submit">
            </form> 
        </div>
        <?php
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