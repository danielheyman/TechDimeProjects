        </div>
        <div id="footer">
            <div class="left">Copyright &copy; 2014 <a target="_blank" href="http://www.techdime.com">TechDime</a></div>
            <!--<div class="right"><a href="<?=$site["url"]?>tos">Terms of Service</a></div>-->
            <div class="right">TechDime Sites: <a target="_blank" href="http://www.brisksurf.com">BriskSurf</a>, <a target="_blank" href="http://www.surfsavant.com">SurfSavant</a></div>
        </div>
    </div>

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
        GrooveWidget.open({category: "Surf Duel"});
        GrooveWidget.close();
        <?php if($usr->loggedIn) {
        ?>
        GrooveWidget.options({about: 'Surf Duel --- Member ID #<?=$usr->data->id?> is a <?=$membership[$usr->data->membership]["name"]?> member.', email: '<?=$usr->data->email?>', name: '<?=$usr->data->fullName?>'}); 
        <?php } else { ?>
        GrooveWidget.options({about: 'Surf Duel --- Not registered.'}); 
        <?php } ?>
    }
</script>
<style>
    
#gw-footer
{
    display:none;   
}
</style>
</body>