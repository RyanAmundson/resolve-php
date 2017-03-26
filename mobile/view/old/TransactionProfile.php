<?php
session_start();
ob_start();
error_reporting(E_ALL);
include 'mobileheader.php';
include 'ApplyCredit.php';
include 'navbartop.php';
#==================redirect if no session=======================================
if(!isset($_SESSION["email"])){
  header("location: Login.php");
}
$uid = $_SESSION['uid'];
//==============================================================================
$firstname;
$lastname;
//=============================================================================================================
//Join and invite
//=============================================================================================================

//=============================================================================================================
//UPDATE PROFILE
//=============================================================================================================
$validated;
$contribution;
$participantCount = ($_GET['numPeople'] +1);
$transactionID = $_GET['transactionID'];


if(!empty($_GET['confirm'])){
	echo "confirm not empty";
	$confirmedID = $_GET['confirm'];
	addActivity($confirmedID," confirmed participation in transaction ".$transactionID,$mysqli);
	$sql = "UPDATE `FI`.`TransactionParticipants` SET `validated` = '1' where uid='$confirmedID' and transactionID='$transactionID'";
	mysqli_query($mysqli,$sql);

	$sql = "select * from TransactionParticipants where transactionID='$transactionID' and validated != '1'";
	$res = mysqli_query($mysqli,$sql);

	if($res->num_rows == 0){

		$sql = "select * from TransactionParticipants where transactionID='$transactionID' and validated = '1'";
		$res = mysqli_query($mysqli,$sql);
		if($res->num_rows > 1){
			while($row = mysqli_fetch_assoc($res)){
				$confirmedID = $row['uid'];
				$sql2 = "select creatorID, totalCost/participantCount as balance from TransactionProfile where transactionID='$transactionID' limit 1";
				$res2 = mysqli_query($mysqli,$sql2);
				$row2 = mysqli_fetch_assoc($res2);
				$creatorID = $row2['creatorID'];
				$balance = $row2['balance'];


				echo "call apply credit".$confirmedID." creator: ".$creatorID;
				if($creatorID != $confirmedID){
					applyCredit($creatorID, $confirmedID, $balance, $mysqli);
				}
			}
		}
	}


	header("location: TransactionProfile.php?transactionID=".$transactionID);
	exit();
}

//=============================================================================================================
//NEW PROFILE
//=============================================================================================================
$sql = "select * from TransactionProfile where transactionID='$transactionID'";
$res = $mysqli->query($sql);

if($res->num_rows == 0){
	$description = $_COOKIE['DescriptionBox'];
	echo $description;
	$creatorID = $_SESSION['uid'];
	$totalPurchaseCost=$_GET['purchaseTotal'];
	$totalAmount=$_GET['total'];
  	$sql = "INSERT INTO FI.TransactionProfile
  	(`totalAmount`,
   	`totalCost`,
  	`participantCount`,
  	`validated`,
  	`date`,
  	`creatorID`,
  	`description`)
  	VALUES
  	('$totalAmount',
  	'$totalPurchaseCost',
  	'$participantCount',
  	'$validated',
  	CURRENT_TIMESTAMP,
  	'$creatorID',
  	'$description')";

  	mysqli_query($mysqli,$sql);

//=====================get transaction id of current============================!!!!!!!!!!!!!!!!!!  probably will cause race conditions with more people
  	$sql3 = "SELECT LAST_INSERT_ID() as tid from FI.TransactionProfile where creatorID = '$creatorID'";
  	$res3 = $mysqli->query($sql3);
  	$row3 = $res3->fetch_assoc();
  	$transactionID = $row3['tid'];
//==============================================================================
  	$count = 0;

  	 $sql5 = "INSERT INTO `FI`.`pendingtransactions`
	(`userid`,
	`transactionid`,
	`time`)
	VALUES
	('$creatorID',
	'$transactionID',
	CURRENT_TIMESTAMP)";
	mysqli_query($mysqli,$sql5);

  	foreach($_GET as $key=>$current){
    	if($key != "total" && $key != "purchaseTotal"){
 			$sql5 = "INSERT INTO `FI`.`pendingtransactions`
			(`userid`,
			`transactionid`,
			`time`)
			VALUES
			('$key',
			'$transactionID',
			CURRENT_TIMESTAMP)";
			mysqli_query($mysqli,$sql5);
		}
	}
	$amounts = array();
	$participants = array();
	$count = 0;

	$sql = "select firstname, lastname from FI.Users where ";

	foreach($_GET as $key=>$current){
	if($key != "numPeople" && $key != "purchaseTotal"){
			array_push($participants,$key);
	        array_push($amounts,$current);
			$sql = $sql . "id=$key or ";
	    }
	}
	$sql = $sql . "id=$creatorID";
	$res = $mysqli->query($sql);
	$sql3 = "";
	$sql3 = "insert into TransactionParticipants values('$transactionID','$creatorID','0','0');";//fix this contrib value
	$mysqli->query($sql3);
	foreach($_GET as $key=>$value){
	    if($key != "numPeople" && $key != "purchaseTotal"){
	        $sql3 = "insert into TransactionParticipants values('$transactionID','$key','$value','0');";
	        $mysqli->query($sql3);
	        addActivity($key,"Were invited to a new <a href=\'TransactionProfile.php?transactionID=$transactionID\'>Transaction</a>",$mysqli);
	    }
	}
	addActivity($creatorID,"Created a new <a href=\'TransactionProfile.php?transactionID=$transactionID\'>Transaction</a>",$mysqli);

	$url = "TransactionProfile.php?transactionID=".$transactionID;
	header('location:'.$url);
	exit();
}

//=============================================================================================================
//EXISTING PROFILE
//=============================================================================================================

$sql8 = "select creatorID, totalAmount, totalCost, participantCount, description from FI.TransactionProfile where TransactionID='$transactionID'";
$res8 = $mysqli->query($sql8);
$row8 = $res8->fetch_assoc();
$creatorID = $row8['creatorID'];
	$sql2 = "select firstname,lastname from FI.Users where id='$creatorID'";
	$res2 = $mysqli->query($sql2);
	$row2 = $res2->fetch_assoc();

echo "<div class='col-md-2 column'></div>";
echo "<div class='col-md-8 column'>";
echo "<div class='col-md-8 column'><div class='page-header'>
  	 	<h1>Transaction Profile</h1><h5> created by <b>".$row2['firstname']." ".$row2['lastname']."</b></h5>
 	 </div>";
echo "<h2>Total Purchase Cost: $".$row8['totalCost']."</h2>";
//echo "<h2>Total Amount Submitted: $".$row8['totalAmount']."</h2><br>";
echo "<table class='table table-condensed table-responsive'>
  		<thead>
    		<tr class='active'><th>#</th><th>Participants</th><th>Split</th><th>Status</th></tr>
  		</thead>
  	  <tbody>";


$count = 1;

$sql10="select TransactionParticipants.transactionID,uid,contribution,firstname, lastname, TransactionParticipants.validated,id creatorID from TransactionParticipants natural join Users where TransactionParticipants.transactionID='$transactionID' and uid=id";
$res10 = $mysqli->query($sql10);


$split = $row8['totalCost']/($row8['participantCount']);

while($row = $res10->fetch_assoc()){
	//echo $res->num_rows;
	$firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $contribution = $row['contribution'];

	if($row['validated'] == 1){
    	$validated = "confirmed";
    	$class = "success";
    }else{
    	$validated = "pending";
    	$class = "warning";
  	}

  	if($_SESSION['uid'] == $row['uid'] && $row['validated'] != 1){
  		echo "<tr class='$class'><td>".$count."</td><td>".$firstname." ".$lastname."</td><td>".$split."</td><td class='$class'><button type='submit' onclick='window.location.href=\"TransactionProfile.php?transactionID=".$transactionID."&confirm=".$row['uid']."\"' name='confirm'>Confirm</button></td></tr>";
  	}else{
    	echo "<tr class='$class'><td>".$count."</td><td>".$firstname." ".$lastname."</td><td>".$split."</td><td class='$class'>".$validated."</td></tr>";
	}
  	$count++;
}
?>

</tbody>
</table>
</div>
<div class='col-md-4 column'>
<div id="ProfileDescription">
<div id="ProfileDescriptionHeader">
<h2>Description</h2>
</div>
<?php
echo "<p>".$row8['description']."</p>";

?>
</div>

</div>




</div>
</div>
</div>


<?php
include 'footer.php';
?>
