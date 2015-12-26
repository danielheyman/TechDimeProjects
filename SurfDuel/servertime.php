<?php
$timeFirst  = strtotime("now");
$timeSecond = strtotime('2013-09-01 00:00:01');
echo ($timeSecond - $timeFirst) * 1000;
?>