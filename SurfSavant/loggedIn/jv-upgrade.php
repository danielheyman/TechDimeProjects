<form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                    <input type="hidden" name="cmd" value="_xclick">
                    <input type="hidden" name="amount" value="<?=$subscriptions[9]["price"]?>">
                    <input type="hidden" name="rm" value="1">
                    <input type="hidden" name="no_note" value="1">
                    <input type="hidden" name="no_shipping" value="1">
                    <input type="hidden" name="business" value="<?=$site["paypal"]?>">
                    <input type="hidden" name="currency_code" value="USD">
                    <input type="hidden" name="item_name" value="<?=$site["name"]?> JV Lifetime Upgrade">
                    <input type="hidden" name="item_number" value="9">
                    <input type="hidden" name="notify_url" value="<?=$site["url"]?>ipn.php">
                    <input type="hidden" name="custom" value="<?=$usr->data->id?>">
                    <input type="hidden" name="cancel_return" value="<?=$site["url"]?>">
                    <input type="hidden" name="return" value="<?=$site["url"]?>">
                    <input type="submit" value='Upgrade Now' name="submit" class="btn btn-default">
                </form>	