<?php
$uid = $_SESSION['uid'];

$sql = "select * from FI.contacts where (contactid = $uid and pending='1') order by pending ASC";
$res = $mysqli->query($sql);


echo "<table id='myTable' border='1'  class='table table-hover table-responsive table-striped table-bordered'>";
echo "<thead class='info'><th>ID</th><th>cid</th><th>Name</th><th>Approve</th></thead><tbody>";

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
      echo "<td onclick=\"document.location.href='UserProfile.php?profileID=$cid'\">". $row3['firstname']." ".$row3['lastname']."</td>";
      echo "<td><button class= 'btn btn-sm info' name='approved' onclick=\"document.location.href='?approved=$contactToApprove'\" value='$contactToApprove'>Approve!</button></td>";
    }

    echo "</tr>";
  }
}
echo "</tbody></table><br>";
?>
