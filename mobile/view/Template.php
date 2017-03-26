
<?php
/*==============================================================================
Includes
==============================================================================*/
ob_start();
session_start();
include_once 'mobileheader.php';
include_once 'navbartop.php';
include_once 'FriendHistory.php';
include_once 'ApplyCredit.php';
include_once 'ActivityLog.php';
/*==============================================================================
Preliminary Processing
==============================================================================*/
$id = $_SESSION['uid'];
$profileID = $id;

$sql = "select * from FI.Users where id='$profileID'";
$res = mysqli_query($mysqli,$sql);
$userInfo = $res->fetch_assoc();

/*==============================================================================
Functions
==============================================================================*/



/*==============================================================================
Display HTML
==============================================================================*/
?>
<body class='maxwidth'>
  <div  class="container">
    <div  class="row clearfix">
      <!-- <div class="column col-xs-12"> -->
    <div style="border-style:solid;background-image:url('../../images/loginbackground.jpg');background-size: 100% 100%;margin-bottom:10px;">
    <center>  <h1 style="color:white;"><?php echo $userInfo['firstname']." ".$userInfo['lastname'];?></h1></center>
    </div>

  <div id='ViewBar'>
    <div class='panel panel-default'>
      <div id='viewbar-panel' class='panel-heading'>
        <button id='viewbar-button1' name='MyCredit'>My Credit</button>
        <button id='viewbar-button2' name='Recent'>Recent</button>
        <button id='viewbar-button3' name='ActivityDescription'> Activity</button>
      </div>
    </div>
  </div>



    <div id='MyCredit' class="panel panel-default">
      <?php

        if($id != $profileID){
          echo "<h3>Current Balance with this person:". checkExistingBalance($id, $profileID, $mysqli)."</h3>";
        } else {
          include_once("totalCredit.php");
        }


      ?>
    </div>

    <div id='ActivityDescription' class="panel panel-default" hidden>
      <?php
        displayActivity($id, $mysqli);
      ?>
    </div>

    <div id='Recent' class="panel panel-default" style='overflow-x:hidden' hidden>
      <?php
        recentActivity($id, $profileID, $mysqli);
      ?>
    </div>
  </div>
</div>
</body>

<!--============================================================================
Scripts *loaded after html
=============================================================================-->
<script src="../javascript/UserProfile.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $('#TransactionsTable').DataTable();
});
</script>



<?php
/*==============================================================================
footer
==============================================================================*/
include 'footer.php';
?>
