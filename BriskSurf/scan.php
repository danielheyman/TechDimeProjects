<?php
die("You seemed to have stumbled upon a magical page that doesn't actually exist. High five. As a matter of fact, I think you are so awesome that I am going to recommend my favorite tool, <a href='http://surfsavant.com'>Surf Savant</a>. Sha bam.");
include 'cleanConfig.php';

if($sec->get("id")) $id = $sec->get("id");
else $id = 0;
$result = $db->query("select id, url, userid from websites where credits >= '1' && id = '{$id}' LIMIT 1");
$result = $result->getNext();
$next = $db->query("select id from websites where credits >= '1' && id > {$id} order by id asc LIMIT 1");
$next = $next->getNext()->id;

?>
<script src="<?=$site["url"]?>jquery-latest.js" type="text/javascript"></script>

<script>
var prevent_bust = 0;
function gonext() {
    prevent_bust = -5;
    window.location = "scan.php?id=<?=$next?>";
}
$(document).ready(function(){
    window.onbeforeunload = function() { prevent_bust++ }
    setInterval(function() {
      if (prevent_bust > 0) {
        prevent_bust -= 2;
        window.top.location = 'http://techdime.com/204.php';
      }
    }, 1);
});
</script>
<?php

echo "<a target='_blank' href='http://www.techdime.com/report.php'>Report</a> <a target='_blank' href='http://www.techdime.com/reportde.php'>Report & Deactivate</a> SiteID: {$result->id} URL: {$result->url} UserID: {$result->userid} <a href='javascript:gonext();'><button autofocus>Next</button></a><br><br><iframe style='width:100%; height:100%;' src='{$result->url}'></iframe>'";
?>