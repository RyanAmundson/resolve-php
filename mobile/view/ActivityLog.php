<?php

function addActivity($id,$tid, $data, $mysqli){
	$des = $data['description'];
	$sql = "insert into FI.ActivityLog (uid,tid,date,description) VALUES ('$id','$tid',CURRENT_TIMESTAMP,'$des')";
	mysqli_query($mysqli,$sql);

}

function displayActivity($id, $mysqli){

	$sql = "SELECT * from FI.ActivityLog WHERE uid = '$id' order by date DESC";
	$result = mysqli_query($mysqli,$sql);
	echo "<h3>Activity Log</h3>";
	$bgcolor = 0;
	while($row = mysqli_fetch_assoc($result)){

		if($bgcolor%2 == 0){
			$c = 'lightgray';
		}else{
			$c = 'white';
		}
		$bgcolor++;

		$date = new DateTime();
		$date->setTimestamp(strtotime($row['date']));
		$interval = $date->diff(new DateTime('now'));
		$formatter = "";
		if($interval->y > 0){
			$formatter .= "%y y ";
			$formatter .= "%m mon";


		}
		elseif($interval->m > 0){
			$formatter .= "%m mon ";
			$formatter .= "%d d";
		}
		elseif($interval->d > 0){
			$formatter .= "%d d ";
			$formatter .= "%h h";
		}
		elseif($interval->h > 0){
			$formatter .= "%h h ";
			$formatter .= "%i m";
		}
		elseif($interval->i > 0){
			$formatter .= "%i m ";
			$formatter .= "%s s";
		}
		elseif($interval->s > 0){
			$formatter .= "%s s";
		}



		echo "<li style='background-color:$c'>".$row['description']." ";
		echo "<span style='float:right;color:darkblue'>".$interval->format($formatter)."</span>";
		echo "</li>";
	}
}

function displayTransactionActivity($tid, $mysqli){

	$sql = "SELECT * from FI.ActivityLog WHERE tid = '$tid' order by date DESC";
	$result = mysqli_query($mysqli,$sql);
	echo "<h3>Activity Log</h3>";
	echo "<ul>";
	while($row = mysqli_fetch_assoc($result)){

		echo "<li>".getUser($row['uid'],$mysqli)." ".$row['description']." ";

		$date = new DateTime();
		$date->setTimestamp(strtotime($row['date']));
		$interval = $date->diff(new DateTime('now'));
		$formatter = "";
		if($interval->y > 0){
			$formatter .= "%y years, ";
			$formatter .= "%m months, ";
			$formatter .= "%d days, ";
			$formatter .= "%h hours, ";
			$formatter .= "%i minutes and ";

		}
		elseif($interval->m > 0){
			$formatter .= "%m months, ";
			$formatter .= "%d days, ";
			$formatter .= "%h hours, ";
			$formatter .= "%i minutes and ";
		}
		elseif($interval->d > 0){
			$formatter .= "%d days, ";
			$formatter .= "%h hours, ";
			$formatter .= "%i minutes and ";
		}
		elseif($interval->h > 0){
			$formatter .= "%h hours, ";
			$formatter .= "%i minutes and ";
		}
		elseif((int)$interval->i > 0){
			$formatter .= "%i minutes and ";
		}
		$formatter .= "%s seconds ago";
		echo $interval->format($formatter);

		echo "</li>";
	}
	echo "</ul>";
}

function getUser($uid, $mysqli){

	$sql = "SELECT * from FI.Users WHERE id = '$uid' ";
	$result = mysqli_query($mysqli,$sql);
	$row = mysqli_fetch_assoc($result);
	return $row['firstname']." ".$row['lastname'];


}





?>
