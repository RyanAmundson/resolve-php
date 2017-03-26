








<?php
$mysqli = fConnectToDatabase();

$uid = $_SESSION['uid'];

$transactions;
$contacts;
$total;



function checkContactRequests($uid, $mysqli){
	$sql = "select COUNT(*) from FI.contacts where contactid='$uid' and pending=1";
	$result = mysqli_query($mysqli, $sql);
	$row = mysqli_fetch_assoc($result);

	if($row['COUNT(*)'] >0){
		return $row['COUNT(*)'];
	}	
}

function checkTransactionRequests($uid, $mysqli){

	$sql = "select COUNT(*) from TransactionParticipants natural join TransactionProfile  where uid = '$uid' and validated = 0";
	$result = mysqli_query($mysqli, $sql);
	$row = mysqli_fetch_assoc($result);

	
	if($row['COUNT(*)'] >0){
		return $row['COUNT(*)'];
	}	


}

function checkTotal($uid, $mysqli){

	$a = checkTransactionRequests($uid, $mysqli);
	$b = checkContactRequests($uid, $mysqli);

	$c =  $a + $b;
	echo $c;
}



?>