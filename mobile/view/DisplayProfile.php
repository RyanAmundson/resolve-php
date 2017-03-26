<?php
session_start();
ob_start();
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(E_ALL);
include_once 'mobileheader.php';
include_once 'navbartop.php';
include_once 'ApplyCredit.php';
include_once 'ActivityLog.php';
#==================redirect if no session=======================================
if(!isset($_SESSION["email"])){
  header("location: Login.php");
}
#===============================================================================
?>

<?php
function displayProfile($transactionID){
  $creatorID = getCreatorID($transactionID);
  	$sql = "select firstname,lastname from FI.Users where id='$creatorID'";
  	$res = $mysqli->query($sql);
  	$row = $res->fetch_assoc();
}

function getProfile($transactionID, $mysqli){
  $results = array();
  $creatorID = -1;

  $sql = "select creatorID, totalAmount, totalCost, participantCount, description from FI.TransactionProfile where TransactionID='$transactionID'";
  $res = $mysqli->query($sql);
  $row = $res->fetch_assoc();
  $creatorID = $row['creatorID'];

  $results['creatorID'] = $creatorID;
  $results['totalCost'] = $row['totalCost'];
  $results['participantCount'] = $row['participantCount'];
  $results['description'] = $row['description'];

  $sql2 = "select firstname,lastname from FI.Users where id='$creatorID'";
  $res2 = $mysqli->query($sql2);
  $row2 = $res2->fetch_assoc();

  $results['creatorName'] = $row2['firstname']." ".$row2['lastname'];

  return $results;
}

function participantTable($transactionID, $uid,$mysqli){

  $thead = "<thead>
            <tr class='active'><th>#</th><th>Participants</th><th>Contribution</th><th>Split</th><th>Status</th></tr>
            </thead>";

  $tbody = "<tbody>";


  $sql="select TransactionParticipants.transactionID,uid,contribution,firstname,
          lastname, TransactionParticipants.validated,id creatorID
          from TransactionParticipants natural join Users
          where TransactionParticipants.transactionID='$transactionID' and uid=id";
  $res = $mysqli->query($sql);

  $profileInfo = getProfile($transactionID, $mysqli);
  //$split = $profileInfo['totalCost']/($profileInfo['participantCount']);
  $split = 0;
  $count = 1;
  while($row = $res->fetch_assoc()){
    $validated = "";
    $class = "";

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

    	if($uid == $row['uid'] && $row['validated'] != 1){
    		$tbody .= "<tr class='$class'>
                <td>".$count."</td>
                <td>".$firstname." ".$lastname."</td>
                <td>".$split."</td>
                <td>".$split."</td>
                <td class='$class'><button type='submit' onclick='window.location.href=\"UpdateProfile.php?transactionID=".$transactionID."&confirm=".$row['uid']."\"' name='confirm'>Confirm</button></td>
              </tr>";
    	}else{
      	$tbody .= "<tr class='$class'>
                <td>".$count."</td>
                <td>".$firstname." ".$lastname."</td>
                <td>".$split."</td>
                <td>".$split."</td>
                <td class='$class'>".$validated."</td>
              </tr>";
  	}
    	$count++;
  }

  $tbody .= "</tbody>";


  $table = "<table class='table table-condensed table-responsive'>";
  $table .= $thead;
  $table .= $tbody;
  $table .= "</table>";

  return $table;

}
?>

<?php
  $mysqli = fConnectToDatabase();
  $uid = $_SESSION['uid'];
  $transactionID = $_GET['transactionID'];
  $profileInfo = array();
  $profileInfo = getProfile($transactionID, $mysqli);
?>

<!----------------------------------------------------------------------------->

<body class="maxwidth">
<div id='content' class="row clearfix" >
  <div>
    <div id='pageheader' class='page-header'>
      <h2>Transaction Profile</h2>
      <h5> Created by <b><?php echo $profileInfo['creatorName']; ?></b></h5>

    </div>
    <div id='ViewBar'>
      <div class='panel panel-default'>
        <div id='viewbar-panel' class='panel-heading'>
          <button id='viewbar-button1' name='ProfileDescription'> Participants</button>
          <button id='viewbar-button2' name='Description'> Description</button>
          <button id='viewbar-button3' name='ActivityDescription'> Activity</button>
        </div>
      </div>
    </div>
    <div class='panel panel-default'>
     <h3>Total Purchase Cost: <?php echo $profileInfo['totalCost']; ?></h3>
     <h3>Participants: <?php echo $profileInfo['participantCount']; ?></h3>
   </div>
<!--  -->
    <div id='ProfileDescription' hidden>
      <?php
      echo participantTable($transactionID,$uid, $mysqli);
      ?>
    </div>
<!--  -->
  	<div id="Description" hidden>
  		<div id="ProfileDescriptionHeader">
  			<h2>Description</h2>
      </div>
        <?php
          echo "<p>".$profileInfo['description']."</p>";
        ?>
  	</div>

<!--  -->

    <div id="ActivityDescription" hidden>
      <div id="ActivityDescriptionHeader">
        <h2>Activity</h2>
      </div>

      <?php displayTransactionActivity($transactionID,$mysqli); ?>

    </div>

<!--  -->

  </div>
</div>

<script src="../javascript/TransactionProfile.js"></script>
</body>
<?php include 'footer.php'; ?>
