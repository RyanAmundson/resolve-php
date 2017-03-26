  <?php
  session_start();
  ob_start();
  include_once 'mobileheader.php';
  include_once 'navbartop.php';
  include_once 'FriendHistory.php';
  include_once 'ApplyCredit.php';
  include_once 'ActivityLog.php';
  #==================redirect if no session=======================================
  if(!isset($_SESSION["email"])){
    header("location: Login.php");
  }else if(empty($_GET['profileID'])){
    //header("location: Login.php?profileID".$SESSION['uid']);
  }
  #===============================================================================
  $id = $_SESSION['uid'];
  $profileID = $id;
  if(!empty($_GET['profileID'])){
    $profileID = $_GET['profileID'];
    $sql = "select * from FI.Users where id='$profileID'";
  }else{
    $sql = "select * from FI.Users where id='$id'";
  }
  //$sql2 = "select * from FI.TransactionProfile where CreatorID=$id";


  $res = mysqli_query($mysqli,$sql);
  $userInfo = $res->fetch_assoc();
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

<script src="../javascript/UserProfile.js"></script>
  <script type="text/javascript">

  $(document).ready(function(){
      $('#TransactionsTable').DataTable();
  });

  </script>
  </body>


  <?php
  include 'footer.php';
  ?>
