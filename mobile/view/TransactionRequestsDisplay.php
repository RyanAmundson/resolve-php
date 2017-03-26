<?php

$table  = "";
$uid = $_SESSION['uid'];

$sql = "select distinct TransactionProfile.totalCost, TransactionParticipants.validated,TransactionProfile.creatorID,TransactionProfile.transactionID,TransactionProfile.totalAmount from TransactionParticipants natural join TransactionProfile  where uid = '$uid' and validated = 0 order by transactionID DESC;";
$result = $mysqli->query($sql);
$validationCount = 0;
$participantCount = 0;



$table = $table . "<table class ='table table-responsive table-condensed table-hover' border='1' id='TransactionRequestsTable'>";
$table = $table . "<thead><th>#</th><th>Cost</th></thead><tbody>";
if ($result->num_rows > 0) {
  $count = 1;

  while($row = $result->fetch_assoc()){

    $transactionID = $row['transactionID'];



      $table = $table . "<tr onclick=\"document.location.href='DisplayProfile.php?transactionID=".$row['transactionID']."'\"><td>$count</td>";
      $table = $table . "<td>$".$row['totalCost']."</td></tr>";

      $count++;

  }
}else{
  echo "0 results";
}
$table = $table . "</tbody></table><br>";

echo $table;

















 ?>
 <script type="text/javascript">

 $(document).ready(function(){
     $('#TransactionRequestsTable').DataTable();
 });

 </script>
