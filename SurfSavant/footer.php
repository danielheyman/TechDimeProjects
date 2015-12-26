    
    
        
    </div>
</div>
    
    
    


<div class="extra">

	<div class="container">

		<div class="row">
			
			<div class="col-md-3">
				<h4>Matt Baker</h4>
				<p>The most awesome guy you will ever meet. He can turn any day into a great one.</p>
                <img src="http://www.gravatar.com/avatar/1745a7a47ae81329de35fe3f99ad5a37?s=100"><br><br>
			</div>
			<!--<div class="col-md-3">
				<h4>Yogesh Dhamija</h4>
				<p>Surf Savant's one and only editor! Co-Owner of <a target="_blank" href="http://techdime.com">TechDime</a>.</p>
                <img src="http://www.gravatar.com/avatar/69b4f9547bdd881b7363f9a4a50c0c0a?s=100"><br><br>
			</div>-->
			<div class="col-md-3">
				<h4>Daniel Heyman</h4>
				<p>He sees and breathes code, but you can blame him for any bugs you find.</p>
                <img src="http://www.gravatar.com/avatar/310184a4125a9aa94c376cec399a612a?s=100"><br><br>
			</div>
            
            <div class="col-md-3">
                <h4>A Little Fun Quote</h4>
                <p style="text-align:justify;">Do the one thing you think you cannot do. Fail at it. Try again. Do better the second time. The only people who never tumble are those who never mount the high wire. This is your moment. Own it.</p>
                <p style="text-align:right;">-- Oprah Winfrey</p>
            </div>
			
			<div class="col-md-3">
				
				<h4>Need Assistance?</h4>
				
				<ul>
					<!--<li><a href="<?=$site["url"]?>contact">Contact Support</a></li>-->
					<li><a href="<?=$site["url"]?>faq">Frequently Asked Questions</a></li>
					<li><a href="<?=$site["url"]?>tos">Terms of Service</a></li>
				</ul>
				
			</div> <!-- /span3 -->
			
		</div> <!-- /row -->

	</div> <!-- /container -->

</div> <!-- /extra -->


    

<div class="footer">
		
	<div class="container">
		
		<div class="row">
			
			<div id="footer-copyright" class="col-md-6">
				Copyright &copy; 2014 <a href="http://techdime.com" target="_blank">TechDime</a>
			</div> <!-- /span6 -->
			
			<div id="footer-terms" class="col-md-6">
				<!--Combined effort of <a target="_blank" href="http://surfingsocially.com">Matt Baker</a> and <a target="_blank" href="http://www.techdime.com">TechDime</a>-->
			</div> <!-- /.span6 -->
			
		</div> <!-- /row -->
		
	</div> <!-- /container -->
	
</div> <!-- /footer -->


<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!--<script src="<?=$site["url"]?>res/js/libs/jquery-ui-1.10.0.custom.min.js"></script>-->
<script src="<?=$site["url"]?>res/js/libs/bootstrap.min.js"></script>

<script src="<?=$site["url"]?>res/js/plugins/flot/jquery.flot.js"></script>
<script src="<?=$site["url"]?>res/js/plugins/flot/jquery.flot.pie.js"></script>
<script src="<?=$site["url"]?>res/js/plugins/flot/jquery.flot.resize.js"></script>

<script src="<?=$site["url"]?>res/js/plugins/msgGrowl/js/msgGrowl.js"></script>
<script src="<?=$site["url"]?>res/js/plugins/msgbox/jquery.msgbox.min.js"></script>


<script src="<?=$site["url"]?>res/js/plugins/cirque/cirque.js"></script>


<script src="<?=$site["url"]?>res/js/Application.js"></script>

<!--<script src="<?=$site["url"]?>res/js/charts/area.js"></script>-->
<script src="<?=$site["url"]?>res/js/charts/donut.js"></script>

<script type='text/javascript'>
  //<![CDATA[
    var grooveOnLoad = myInitFunction; 
    (function() {var s=document.createElement('script');
      s.type='text/javascript';s.async=true;
      s.src=('https:'==document.location.protocol?'https':'http') + '://techdime.groovehq.com/widgets/d4cb2127-aa02-4b2f-a26d-dd2452c1f385/ticket.js'; 
      var q = document.getElementsByTagName('script')[0];q.parentNode.insertBefore(s, q);})();
  //]]>
    function myInitFunction()
    {
        GrooveWidget.open({category: "Surf Savant"});
        GrooveWidget.close();
        <?php if($usr->loggedIn) { 
        $result = $db->query("SELECT SUM(`amount`) AS `sum` FROM `commissions` WHERE `status` = '1' && `userid` = '{$usr->data->id}'");
        $sum = number_format($result->getNext()->sum,3);
        $sum = ($sum == "") ? "0" : $sum;
        ?>
        GrooveWidget.options({about: 'Surf Savant --- Member ID #<?=$usr->data->id?> is a  <?=$membership[$usr->data->membership]["name"]?> member. At level <?=$usr->data->level?> with <?=$usr->data->level?> coins and $<?=$sum?> earned.', email: '<?=$usr->data->email?>', name: '<?=$usr->data->fullName?>'}); 
        <?php } else { ?>
        GrooveWidget.options({about: 'Surf Savant --- Not registered.'}); 
        <?php } ?>
    }
</script>
<style>
#groove-feedback.right
{
    right: 20px;
}
    
#back-to-top
{
    bottom:50px;
}
    
#gw-footer
{
    display:none;   
}
</style>

  </body>
</html>