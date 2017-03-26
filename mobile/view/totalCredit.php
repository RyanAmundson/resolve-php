<?php

include_once 'functions.php';

$total = totalCredit($uid,$mysqli);
$status =  'success';
if ($total >= 0){
	$status = 'success';
}else{
	$status = 'danger';
}
echo "<div class='panel panel-default ".$status."'>
          <div class='panel-body ".$status."'>";
echo "<h4>$total</h4>";
echo "</div></div>";

?>
