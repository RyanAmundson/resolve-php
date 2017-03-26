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


//$dropdownMiddle = "";
//$dropdownEnd = "</ul></li></ul></div><!-- /.navbar-collapse --></nav>";

$sql = " select distinct TransactionParticipants.transactionID, uid,totalCost,creatorID,totalAmount from TransactionParticipants join TransactionProfile where uid =$uid and TransactionParticipants.transactionID = TransactionProfile.transactionID";
$result = $mysqli->query($sql);

echo "<body>";
//========================================Build table================================================================================================
$table = $table . "<table class='table table-responsive table-condensed table-hover' id='TransactionsTable'>";
$table = $table . "<thead><th>#</th><th>Cost</th><th>Status</th></thead><tbody>";
$validationCount = 0;
$participantCount = 0;
if ($result->num_rows > 0) {
  $count = 1;

  while($row = $result->fetch_assoc()){
    $cidSet = 0;
    $transactionID = $row['transactionID'];
    $sql4 = "select id, firstname, lastname, validated from TransactionParticipants natural join Users where transactionID='$transactionID' and uid=id";
    $result4 = $mysqli->query($sql4);
    //$dropDownMiddle = "";
    //$row4 = $result4->fetch_assoc();// skip first row

    while($row4 = $result4->fetch_assoc()){
      if($row4['validated'] == 1){
        $validationCount++;
        $participantCount++;
      }
      else{
        $participantCount++;
      }

      // if($row4['id'] == $row['creatorID'] && $cidSet == 0){
      //   $dropdownStart ="<nav class='navbar admin-menu' role='navigation'><div class='collapse navbar-collapse' id='bs-example-navbar-collapse-1'><ul class='nav navbar-nav navbar-right'><li class='dropdown'><a href='UserProfile.php?profileID=".$row4['id']."'>".$row4['firstname']." ".$row4['lastname']."<b class='caret'></b></a><ul class='dropdown-menu'>";
      //           $cidSet = 1;
      // }else if($row4['id'] != $row['creatorID']){
      //   $dropDownMiddle = $dropDownMiddle."<li><a href='UserProfile.php?profileID=".$row4['id']."'>".$row4['firstname']." ".$row4['lastname']."</a></li>";
      // }

    }


      $table = $table . "<tr onclick=\"document.location.href='DisplayProfile.php?transactionID=".$row['transactionID']."'\"><td>$count</td>";
      $table = $table . "<td>$".$row['totalCost']."</td>";
      //$table = $table . "<td>".$dropdownStart.$dropDownMiddle.$dropdownEnd."</td>";


      if ($validationCount == $participantCount){
        $table = $table . "<td>Complete</td></tr>";
      }else{
        $table = $table . "<td>".$validationCount."/".$participantCount."</td></tr>";
      }


      $count++;
      $validationCount = 0;
      $participantCount = 0;
  }
}else{
  echo "0 results";
}
$table = $table . "</tbody></table><br>";
//========================================================================================================================================================

echo "<div class='col-md-2 col-xs-0 column'></div>";
echo "<div class='col-md-8 col-xs-12 column'>";
echo "<div class='panel panel-default'>";
echo "<div class='panel panel-heading'>Transaction Requests</div>";
echo $table;
echo "</div></div>";
echo "<div class='col-md-2 col-xs-0 column'></div>";
?>
<script type="text/javascript">

$(document).ready(function(){
    $('#TransactionsTable').DataTable();
});

</script>

<?php

echo"</body>";
include 'footer.php';
?>

<br>
<!-- 
    <style type='text/css'>
        ul.nav li.dropdown:hover ul.dropdown-menu {
            display: block;
        }
    </style> -->
</html>
