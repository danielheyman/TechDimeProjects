<?php include 'header.php'; ?>
<?php $subscription = 1; $subscription2 = 2; ?>
<link href="<?=$site["url"]?>res/css/pages/plans.css" rel="stylesheet"> 
<link href="<?=$site["url"]?>res/css/pages/pricing.css" rel="stylesheet"> 
<div class="row">
    <div class="col-md-12">
        <div class="widget stacked">
                
            <div class="widget-header">
                <i class="icon-th-large"></i>
                <h3>Choose Your Plan</h3>
            </div>
            <div class="widget-content">
                <div class="pricing-header">
                    
                    <h1>You are a <?php echo $membership[$usr->data->membership]["name"]; ?> member.</h1>
                    <h2>No hidden fees. Cancel at anytime. No risk.</h2>
                    <br>
                    <b style="color: #777;">* Referral earnings include their surfing bonuses, paid to click earnings, and much more coming soon.<br>Earnings for the whole day are added to your account every day at midnight if you remain active.<br>** You will earn commissions on upgrades and coin purchases for all your referrals.</b>
                </div> <!-- /.pricing-header -->
                
                <div class="pricing-plans plans-4">
                    <div class="plan-container" style="width:33%;">
                        <div class="plan stacked">
                            <div class="plan-header">
                                <div class="plan-title">
                                    Free	        		
                                </div>
                                <div class="plan-price">
                                    Free<span class="term">For Life</span>
                                </div>
                            </div>
                            <div class="plan-features">
                                <ul>
                                    <li><strong><?=$membership["0001"]["refEarnings"] * 100?>%</strong> of Referral Earnings *</li>
                                    <li><strong><?=$membership["0001"]["refCommisionPercent"] * 100?>%</strong> Commissions **</li>
                                    <li><strong>Slow</strong> Rotator Traffic</li>
                                    <li><strong><?=$membership["0001"]["monthlyVacation"]?></strong> Monthly Vacation Days</li>
                                    <li><strong><?=$membership["0001"]["monthlyCoins"]?></strong> Monthly Coins</li>
                                    <li><strong>Free</strong> Splash Page</li>
                                    <li><strong>Free</strong> Tutorial Series</li>
                                    <li><strong>Limited</strong> Branding Stats</li>
                                </ul>
                            </div>
                            <div class="plan-actions">	
                                <a style="width: 80%; margin:auto;" href="javascript:;" class="btn btn-default">It's Free</a>				
                            </div>
                        </div>
                    </div>
                    <div class="plan-container" style="width:33%;">
                        <div class="plan stacked orange">
                            <div class="plan-header">
                                <div class="plan-title">
                                    Pro Monthly      		
                                </div>
                                <div class="plan-price">
                                    <span class="note">$</span>9<span class="term">Per Month</span>
                                </div>
                            </div>
                            <div class="plan-features">
                                <ul>	
                                    <li><strong><?=$membership["0002"]["refEarnings"] * 100?>%</strong> of Referral Earnings *</li>
                                    <li><strong><?=$membership["0002"]["refCommisionPercent"] * 100?>%</strong> Commissions **</li>
                                    <li><strong>Fast</strong> Rotator Traffic</li>
                                    <li><strong><?=$membership["0002"]["monthlyVacation"]?></strong> Monthly Vacation Days</li>
                                    <li><strong><?=$membership["0002"]["monthlyCoins"]?></strong> Monthly Coins</li>
                                    <li><strong>Exclusive</strong> Splash Pages</li>
                                    <li><strong>Exclusive</strong> Tutorial Series (soon)</li>
                                    <li><strong>Expanded</strong> Branding Stats</li>
                                </ul>
                            </div>
                            <div class="plan-actions">		
                                <form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                                    <input type="hidden" name="cmd" value="_xclick-subscriptions">
                                    <input type="hidden" name="a3" value="<?=$packages[$subscription]["price"]?>">
                                    <input type="hidden" name="p3" value="1">
                                    <input type="hidden" name="t3" value="M">
                                    <input type="hidden" name="src" value="1">
                                    <input type="hidden" name="no_shipping" value="1">
                                    <input type="hidden" name="business" value="<?=$site["paypal"]?>">
                                    <input type="hidden" name="currency_code" value="USD">
                                    <input type="hidden" name="item_name" value="<?=$site["name"]?> Pro Monthly Upgrade">
                                    <input type="hidden" name="item_number" value="<?=$subscription?>">
                                    <input type="hidden" name="notify_url" value="<?=$site["url"]?>ipn.php">
                                    <input type="hidden" name="custom" value="<?=$usr->data->id?>">
                                    <input type="hidden" name="cancel_return" value="<?=$site["url"]?>">
                                    <input type="hidden" name="return" value="<?=$site["url"]?>success/">
                                    <input style="width: 80%; margin:auto;" type="submit" value='Purchase Now' name="submit" class="btn btn-default">
                                </form>	
                            </div>
                        </div>
                    </div> 
                    <div class="plan-container" style="width:33%;">
                        <div class="plan stacked">
                            <div class="plan-header">
                                <div class="plan-title">
                                    Pro Annual   		
                                </div>
                                <div class="plan-price">
                                    <span class="note">$</span>88<span class="term">Per Year</span>
                                </div>
                            </div>
                            <div class="plan-features">
                                <ul>					
                                    <li><strong><?=$membership["0002"]["refEarnings"] * 100?>%</strong> of Referral Earnings *</li>
                                    <li><strong><?=$membership["0002"]["refCommisionPercent"] * 100?>%</strong> Commissions **</li>
                                    <li><strong>Fast</strong> Rotator Traffic</li>
                                    <li><strong><?=$membership["0002"]["monthlyVacation"]?></strong> Monthly Vacation Days</li>
                                    <li><strong><?=$membership["0002"]["monthlyCoins"]?></strong> Monthly Coins</li>
                                    <li><strong>Exclusive</strong> Splash Pages</li>
                                    <li><strong>Exclusive</strong> Tutorial Series (soon)</li>
                                    <li><strong>Expanded</strong> Branding Stats</li>
                                </ul>
                            </div>
                            <div class="plan-actions">		
                                <form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                                    <input type="hidden" name="cmd" value="_xclick-subscriptions">
                                    <input type="hidden" name="a3" value="<?=$packages[$subscription2]["price"]?>">
                                    <input type="hidden" name="p3" value="1">
                                    <input type="hidden" name="t3" value="Y">
                                    <input type="hidden" name="src" value="1">
                                    <input type="hidden" name="no_shipping" value="1">
                                    <input type="hidden" name="business" value="<?=$site["paypal"]?>">
                                    <input type="hidden" name="currency_code" value="USD">
                                    <input type="hidden" name="item_name" value="<?=$site["name"]?> Pro Annual Upgrade">
                                    <input type="hidden" name="item_number" value="<?=$subscription2?>">
                                    <input type="hidden" name="notify_url" value="<?=$site["url"]?>ipn.php">
                                    <input type="hidden" name="custom" value="<?=$usr->data->id?>">
                                    <input type="hidden" name="cancel_return" value="<?=$site["url"]?>">
                                    <input type="hidden" name="return" value="<?=$site["url"]?>success/">
                                    <input style="width: 80%; margin:auto;" type="submit" value='Purchase Now' name="submit" class="btn btn-default">
                                </form>			
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
<?php include 'footer.php';?>