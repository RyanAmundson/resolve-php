<?php
session_start();
include 'mobileheader.php';
include 'navbartop.php';
#==================redirect if no session=======================================
if(!isset($_SESSION["email"])){
  header("location: Login.php");
}
$uid = $_SESSION['uid'];
#===============================================================================

if($mysqli_connect_errno){
  echo "failed to connect to FI";
}


$dropdownMiddle = "";
$dropdownEnd = "</ul></li></ul></div><!-- /.navbar-collapse --></nav>";

$sql = "select distinct TransactionProfile.totalCost, TransactionParticipants.validated,TransactionProfile.creatorID,TransactionProfile.transactionID,TransactionProfile.totalAmount from TransactionParticipants natural join TransactionProfile  where uid = '$uid' and validated = 0 order by transactionID DESC;";
$result = $mysqli->query($sql);
$validationCount = 0;
$participantCount = 0;



//========================================Build table================================================================================================

$table = $table . "<table class ='table table-responsive table-condensed table-hover' border='1' id='TransactionRequestsTable'>";
$table = $table . "<thead><th>#</th><th>Cost</th><th>Status</th></thead><tbody>";
if ($result->num_rows > 0) {
  $count = 1;

  while($row = $result->fetch_assoc()){

      if($row['validated'] == 1){
        $status = " Complete ";
      }
      else{
        $status = " In Progress ";
      }
    $transactionID = $row['transactionID'];



      $table = $table . "<tr onclick=\"document.location.href='DisplayProfile.php?transactionID=".$row['transactionID']."'\"><td>$count</td>";
      $table = $table . "<td>$".$row['totalCost']."</td>";



      $table = $table . "<td>$status</td></tr>";

      $count++;

  }
}else{
  echo "0 results";
}
$table = $table . "</tbody></table><br>";
//========================================================================================================================================================

//print table
echo "<body>";

echo "<div class='col-md-2 column'></div>";
echo "<div class='col-md-8 column'>";
echo "<div class='panel panel-default'>";
echo "<div class='panel panel-heading'>Transaction Requests</div>";
echo $table;
echo "</div></div>";
echo "<div class='col-md-2 column'></div>";
?>
<script type="text/javascript">

$(document).ready(function(){
    $('#TransactionRequestsTable').DataTable();
});

</script>

<?php

echo"</body>";
include 'footer.php';
?>

<br>

    <style type='text/css'>
        ul.nav li.dropdown:hover ul.dropdown-menu {
            display: block;
        }
    </style>
</html>
