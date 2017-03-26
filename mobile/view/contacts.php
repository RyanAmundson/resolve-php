<?php
session_start();
ob_start();
error_reporting(E_ALL);
session_cache_limiter('none');
session_start();
include_once 'mobileheader.php';
include_once 'navbartop.php';
include_once 'ApplyCredit.php';
include_once 'ActivityLog.php';

if(!isset($_SESSION["email"])){
      header("location: Login.php");
}
//==========================add contact box=====================================

echo "<div id='transactiontable' class='panel panel-default'>";
echo "<div id='' class='panel-heading'>Find Friends</div>";
echo "<form method='GET'class='form-horizontal' id='transactiontable'>";
echo "<input class='form-group' style='width:50%' type='text' name='search' placeholder='Add Contact'>";
echo "<input type='submit' value='Search'>";
echo "</form></div>";

//<input type='text' size='30' onkeyup='showResult(this.value)'>
//<div id='livesearch'></div>
//</form><center>";
//============check search results==============================================
if(!empty($_GET['showRequests'])){
  $onlyRequests = $_GET['showRequests'];
}
if(!empty($_GET['search'])){
  findContacts($mysqli, $_GET['search']);
  //$sql7 = "select * from FI.Users";
  //$res7 = mysqli_query($mysqli,$sql7);
  //$xml = sqlToXml($res7,"users","contact");
  //echo $xml;
}

//=============check add contacts===============================================
if(!empty($_GET['contactToAdd'])){
  $id = $_SESSION['uid'];
  $cid = $_GET['contactToAdd'];
  $sql = "insert into FI.contacts values('$id','$cid',CURRENT_TIMESTAMP,'1','0.00')";
  mysqli_query($mysqli,$sql);


  $data = array();
  $data['description'] = "successfully requested friend: ".getUser($cid, $mysqli);
  addActivity($id,0,$data, $mysqli);
  $data = array();
  $data['description'] = getUser($id,$mysqli)." has requested to be your friend";
  addActivity($cid,0,$data, $mysqli);
}

if(!empty($_GET['approved'])){
  $id = $_SESSION['uid'];
  $cid = $_GET['approved'];
  $sql = "insert into FI.contacts values('$id','$cid',CURRENT_TIMESTAMP,'0','0.00')";
  mysqli_query($mysqli,$sql);
  $sql = "update FI.contacts set pending='0', reg_date=CURRENT_TIMESTAMP where uid='$cid' and contactid='$id'";
  mysqli_query($mysqli,$sql);
  $sql = "update FI.contacts set pending='0', reg_date=CURRENT_TIMESTAMP where uid='$id' and contactid='$cid'";
  mysqli_query($mysqli,$sql);


  $data = array();
  $data['description'] = "successfully added friend: ".getUser($cid,$mysqli);
  addActivity($id,0,$data, $mysqli);
  $data = array();
  $data['description'] = "successfully added friend: ".getUser($id,$mysqli);
  addActivity($cid,0,$data, $mysqli);
}
if(!empty($_GET['cancel'])){
  $id = $_SESSION['uid'];
  $cid = $_GET['cancel'];
  $sql = "delete from FI.contacts where contactid='$cid' and uid='$id'";
  mysqli_query($mysqli,$sql);
  $sql = "delete from FI.contacts where contactid='$id' and uid='$cid'";
  mysqli_query($mysqli,$sql);
  header("location: contacts.php");

}
//==============================================================================

echo "<br>";

$uid = $_SESSION['uid'];

$sql = "select * from FI.contacts where uid = $uid or (contactid = $uid and pending='1') order by pending ASC";
$res = $mysqli->query($sql);

echo "<body class='col-md-offset-2 col-md-8 column'>";
echo "<div id='transactiontable' class='panel panel-default'>";
echo "<div id='' class='panel-heading'>Contacts</div>";

echo "<table id='myTable' border='1'  class='table table-hover table-responsive table-striped table-bordered'>";
echo "<thead class='info'><th>ID</th><th>cid</th><th>Name</th><th>Friends Since</th><th>Balance</th></thead><tbody>";

if ($res->num_rows > 0) {
  while($row = mysqli_fetch_assoc($res)){

    $cid = $row['contactid'];

    echo "<tr><td>". $row['uid']."</td>";
    echo "<td>". $row['contactid']."</td>";

    $sql2 = "select * from FI.Users where id='$cid'";
    $res2 = $mysqli->query($sql2);
    $row2 = mysqli_fetch_assoc($res2);

    if($row['contactid'] == $uid && $row['pending'] == 1){
      $status = "info";
      $userid = $row['uid'];
      $sql3 = " select * from FI.Users where id=$userid";
      $res3 = $mysqli->query($sql3);
      $row3 = mysqli_fetch_assoc($res3);
      $contactToApprove = $row3['id'];
      echo "<td onclick=\"document.location.href='UserProfile.php?profileID=$cid'\" class='$status'>". $row3['firstname']." ".$row3['lastname']."</td>";
      echo "<td><button class= 'btn btn-sm info' name='approved' onclick=\"document.location.href='?approved=$contactToApprove'\" value='$contactToApprove'>Approve!</button></td>";
    }else{
      echo "<td onclick=\"document.location.href='UserProfile.php?profileID=$cid'\" class='$status'>". $row2['firstname']." ".$row2['lastname']."</td>";
      if($row['pending'] == 1){
        $status = "warning";
        echo "<td class='$status'>Pending Approval<br><a href=?cancel=".$cid.">cancel</a></td>";

        $status="";
      }else{
        $status="success";
        echo "<td class='$status'>".$row['reg_date']."</td>";
        $status = "";
      }
    }


    echo "<td>";
    echo checkExistingBalance($uid,$cid,$mysqli);
    echo "</td></tr>";
  }
}else{
  echo "0 results";
}
echo "</tbody></table><br>";
echo "<center><a href='index.php'>Go back</a></center>";
?>
<script type="text/javascript">

$(document).ready(function(){
    $('#myTable').DataTable();
});

</script>
<?php
  echo"</body>";


include 'footer.php';
echo "</html>";





function findContacts($mysqli, $search){

  $myId = $_SESSION['uid'];

  $words = preg_split("/\s+/",$search);
  $count = 0;
  $sql = "Select * from FI.Users where ";
  if(!empty($words[0])){
    foreach($words as $word){
      $count++;
      $sql = $sql ."firstname like '%$word%' or lastname like '%$word%'";
      if($count != sizeof($words)){
        $sql = $sql . " or ";
      }
    }
  }
  $result = $mysqli->query($sql);

  echo "<center><form method='GET'>";
  while($row = mysqli_fetch_assoc($result)){

    $contactId = $row['id'];
    $result2 = $mysqli->query("Select * from FI.contacts where uid='$myId' and contactid='$contactId'");

    if($result2->num_rows == 0){
      echo "<button type='submit' name='contactToAdd' value='".$row['id']."'>".$row['firstname']." ".$row['lastname']."</button><br>";
    }

  }
  echo "</form></center>";

}
















?>
