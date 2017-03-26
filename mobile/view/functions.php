<?php


function checkSession(){

  if(!isset($_SESSION["email"])){
    header("location: Login.php");
  }else if(empty($_GET['profileID'])){
    //header("location: Login.php?profileID".$SESSION['uid']);
  }


}





function totalCredit($user, $mysqli){

    $sql = "select SUM(balance) as total from FI.credit where useroneID = '$user'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    return $row['total'];


}
function getUserByID($id, $mysqli){//returns array
	$sql = "select * from FI.Users where uid = '$id";
	$result = mysqli_query($mysqli, $sql);
	$row = mysqli_fetch_assoc($result);
	return $row;
}







?>
