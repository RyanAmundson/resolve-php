<?php
session_start();
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
include 'mobileheader.php';
include 'ApplyCredit.php';
$uid = $_SESSION['uid'];
//=============================================================================================================
//NEW PROFILE
//=============================================================================================================

$participantCount = ($_GET['numPeople'] +1);
$validated = 0;


	$description = $_COOKIE['DescriptionBox'];
	echo $description;
	$creatorID = $_SESSION['uid'];
	$totalPurchaseCost=$_GET['purchaseTotal'];
	$totalAmount=0;
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
	    }
	}
	//=================================================================================
	$data = array();
	$desc = "created <a href=\'DisplayProfile.php?transactionID=$transactionID\'>Transaction</a>";
	$data['description'] = $desc;

	addActivity($creatorID,$transactionID,$data,$mysqli);
	//=================================================================================
	$url = "DisplayProfile.php?transactionID=".$transactionID;
	header('location:'.$url);
	exit();



 ?>
