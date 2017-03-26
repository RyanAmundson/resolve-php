

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

<body class="maxwidth">
<div id='content' class="row clearfix col-xs-12 col-xs-offset-2" >
  <div>
    <div id='pageheader' class='page-header'>
      <h2>Notifications</h2>
    </div>

      <div class='panel panel-default'>
        <div id='viewbar-panel' class='panel-heading'>
          <button id='viewbar-button1' name='FriendRequests'>FR <span class="badge"><?php  echo checkContactRequests($uid, $mysqli);?></span></button>
          <button id='viewbar-button2' name='TransactionRequests'>TR <span class="badge"><?php  echo checkTransactionRequests($uid, $mysqli);?></span></button>
          <button id='viewbar-button3' name='Messages'>Messages</button>
        </div>
      </div>


<!--  -->
    <div id='FriendRequests' hidden>
      <h2>Friend Requests</h2>
      <?php
      include 'ContactRequestDisplay.php';
      ?>
    </div>
<!--  -->
  	<div id="TransactionRequests">
  		<div id="ProfileDescriptionHeader">
  			<h2>Transaction Requests</h2>
      </div>
        <?php
        include 'TransactionRequestsDisplay.php';
        ?>
  	</div>

<!--  -->

    <div id="Messages" hidden>
      <div id="ActivityDescriptionHeader">
        <h2>Messages</h2>
      </div>

      <?php

      ?>

    </div>

<!--  -->

  </div>
</div>

<script src="../javascript/NotificationsDisplay.js"></script>
</body>

<?php include 'footer.php'; ?>
