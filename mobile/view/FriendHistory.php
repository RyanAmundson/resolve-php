<?php

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);


function currentBalance($useroneID, $usertwoID, $mysqli){


	$sql11 = "select balance from FI.credit where useroneID = '$useroneID' and usertwoID = '$usertwoID'";
	$res11 = $mysqli->query($sql11);
	$row11 = mysqli_fetch_assoc($res11);

	$sql12 = "select balance from FI.credit where useroneID = '$usertwoID' and usertwoID = '$useroneID'";
	$res12 = $mysqli->query($sql12);
	$row12 = mysqli_fetch_assoc($res12);
	if ($res11->num_rows > 0) {
		echo "$".$row11['balance'];
	}else if($res12->num_rows > 0){
		echo "-$".$row12['balance'];
	}else{
		echo "<div class='container danger'>$0.00</div>";
	}

}



function recentActivity($useroneID, $usertwoID, $mysqli){


	$sql = "select *
	from (select transactionID as t1, uid as u1 from TransactionParticipants) as q1, (select transactionID as t2,uid as u2 from TransactionParticipants) as q2, ( select * from TransactionProfile) as q3
	where q1.t1 = q2.t2 and u1 = '$useroneID' and u2 = '$usertwoID' and q3.transactionID = q1.t1";

	$res = mysqli_query($mysqli,$sql);
	$row = $res->fetch_assoc();
	$table = "";
	$dropdownMiddle = "";
	$dropdownEnd = "</ul></li></ul></div><!-- /.navbar-collapse --></nav>";
	$table = $table . "<table class='table table-responsive table-condensed table-hover' id='TransactionsTable' >";
	$table = $table . "<thead><th>#</th><th>ID</th><th>Cost</th><th>Participants</th><th>Status</th></thead><tbody>";
	$validationCount = 0;
	$participantCount = 0;
	if ($res->num_rows > 0) {
		$count = 1;





		while($row = $res->fetch_assoc()){
			$cidSet = 0;
			$transactionID = $row['t1'];
			$sql4 = "select id, firstname, lastname, validated from TransactionParticipants natural join Users where transactionID='$transactionID' and uid=id";
			$result4 = $mysqli->query($sql4);
			$dropDownMiddle = "";


			while($row4 = $result4->fetch_assoc()){
				if($row4['validated'] == 1){
					$validationCount++;
					$participantCount++;
				}
				else{
					$participantCount++;
				}

				if($row4['id'] == $row['creatorID'] && $cidSet == 0){
					$dropdownStart ="<nav class='navbar admin-menu' role='navigation'>
					<div class='collapse navbar-collapse' id='bs-example-navbar-collapse-1'><ul class='nav navbar-nav navbar-right'>
					<li class='dropdown'><a href='UserProfile.php?profileID=".$row4['id']."'>".$row4['firstname']." ".$row4['lastname']."<b class='caret'></b></a><ul id='dd' class='dropdown-menu'>";
					$cidSet = 1;
				}else if($row4['id'] != $row['creatorID']){
					$dropDownMiddle = $dropDownMiddle."<li><a href='UserProfile.php?profileID=".$row4['id']."'>".$row4['firstname']." ".$row4['lastname']."</a></li>";
				}

			}


			$table = $table . "<tr onclick=\"document.location.href='DisplayProfile.php?transactionID=".$row['t1']."'\"><td>$count</td><td>". $row['t1']."</td>";
			$table = $table . "<td>$".$row['totalCost']."</td>";
			$table = $table . "<td>".$dropdownStart.$dropDownMiddle.$dropdownEnd."</td>";


			if ($validationCount == $participantCount){
				$table = $table . "<td>ACTIVE</td></tr>";
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
	echo $table;
}


?>

<style type='text/css'>
li.dropdown:hover #dd.dropdown-menu {
	display: block;
}
</style>
