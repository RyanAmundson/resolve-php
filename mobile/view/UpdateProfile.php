<?php
session_start();
ob_start();
ini_set('display_startup_errors',1);
ini_set('display_errors',1);

error_reporting(E_ALL);
include 'mobileheader.php';
include 'navbartop.php';
include 'ApplyCredit.php';
//=============================================================================================================
//UPDATE PROFILE
//=============================================================================================================
$validated;
$contribution;
//$participantCount = ($_GET['numPeople'] +1);
$transactionID = $_GET['transactionID'];


if(!empty($_GET['confirm'])){
	echo "confirm not empty";
	$confirmedID = $_GET['confirm'];
	$sql = "UPDATE `FI`.`TransactionParticipants` SET `validated` = '1' where uid='$confirmedID' and transactionID='$transactionID'";
	mysqli_query($mysqli,$sql);

	$sql = "select * from TransactionParticipants where transactionID='$transactionID' and validated != '1'";
	$res = mysqli_query($mysqli,$sql);

	if($res->num_rows == 0){
		$sql = "select creatorID, totalCost/participantCount as balance from TransactionProfile where transactionID='$transactionID' limit 1";
		$res = mysqli_query($mysqli,$sql);
		$row = mysqli_fetch_assoc($res);
		$creatorID = $row['creatorID'];
		$balance = $row['balance'];


		echo "call apply credit";
		applyCredit($creatorID, $confirmedID,$transactionID, $balance, $mysqli);

	}

	//=================================================================================
	$data = array();
	$desc = "accepted <a href=\'DisplayProfile.php?transactionID=$transactionID\'>Transaction</a>";
	$data['description'] = $desc;

	addActivity($confirmedID,$transactionID,$data,$mysqli);
	//=================================================================================

	header("location: DisplayProfile.php?transactionID=".$transactionID);
	exit();
}

?>
