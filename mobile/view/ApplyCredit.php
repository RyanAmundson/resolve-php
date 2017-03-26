






<?php
ob_start();
error_reporting(E_ALL);
//session_start();
//include 'connection.php';
include 'ActivityLog.php';

//$link = fConnectToDatabase();


function applyCredit($userone, $usertwo,$tid,$balance, $link){
	echo "here";

	$sql = "select * from FI.credit where (useroneID='$userone' and usertwoID='$usertwo') or (useroneID='$usertwo' and usertwoID='$userone')";
	$result = mysqli_query($link, $sql);

	if($result->num_rows > 0){
		echo "<br>balance exists";

		$sql = "update FI.credit set balance=balance+$balance where useroneID='$userone' and usertwoID='$usertwo'";
		$result = mysqli_query($link, $sql);
		$sql = "update FI.credit set balance=balance-$balance where useroneID='$usertwo' and usertwoID='$userone'";
		$result = mysqli_query($link, $sql);

		//=================================================================================
		$data = array();
		$desc = "successfully received ".$balance." credit from " .getUser($usertwo,$link);
		$data['description'] = $desc;

		addActivity($userone,$tid,$data,$link);

		$data = array();
		$desc = "successfully given ".$balance." credit to " .getUser($userone,$link);
		$data['description'] = $desc;

		addActivity($usertwo,$tid,$data,$link);
		//=================================================================================

	}else{
		echo "<br>need to create entry";

		$sql = "insert into FI.credit values ('$userone', '$usertwo','$balance')";
		mysqli_query($link,$sql);
		$sql = "insert into FI.credit values ('$usertwo', '$userone','-$balance')";
		mysqli_query($link,$sql);

		echo "successfully updated balance. Maybe...";

		//=================================================================================
		$data = array();
		$desc = "successfully received ".$balance." credit from " .getUser($usertwo,$link);
		$data['description'] = $desc;

		addActivity($userone,$tid,$data,$link);

		$data = array();
		$desc = "successfully given ".$balance." credit to " .getUser($userone,$link);
		$data['description'] = $desc;

		addActivity($userone,$tid,$data,$link);
		//=================================================================================

	}


}


function checkExistingBalance($userone, $usertwo, $mysqli){


	$sql = "select * from FI.credit where (useroneID='$userone' and usertwoID='$usertwo')";
	$res = $mysqli->query($sql);
    $row = mysqli_fetch_assoc($res);


    if ($res->num_rows > 0) {
    	return $row['balance'];
    }
    return 0.00;

}



?>
