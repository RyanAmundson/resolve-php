<!-- Home Page-->


<!--============================================================================
Includes
=============================================================================-->
<?
ob_start();
session_start();//must be first thing on page
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
include 'mobileheader.php';//include header file
include 'navbartop.php';
include 'functions.php';
?>


<!--============================================================================
Preliminary Processing
=============================================================================-->
<?
if(!isset($_SESSION["email"])){header("location: Login.php");} //redirect if no session

$uid = $_SESSION['uid'];





?>
<!--============================================================================
Functions
=============================================================================-->
<script src='../javascript/index.js'></script>


<!--============================================================================
Display HTML
=============================================================================-->
<center>
<body class="maxwidth">
  <div id='content' class="row clearfix">

    <div class="col-md-2 col-xs-0 column">
    </div>

    <div class="col-md-8 col-xs-12 column">
      <div class='row'>
        <div class='col-md-12'>
        </div>
      </div>

      <div class='row'>
        <div class='col-md-0'>
        </div>
        <div id="CI" class='col-md-6 col-xs-6'>
          <?php include('CashInput.php'); ?>
        </div>
        <div id="JT" class='col-md-6 col-xs-6'>
          <?php include('JoinTransaction.php');?>
        </div>
        <div class='col-md-0'>
        </div>
      </div>

      <div class='row'>
        <div id='ContactBox' class='col-md-12'>
          <?php include('ContactBox.php'); ?>
        </div>
      </div>
      <div class='row'>
        <div id='DescriptionBox' class='col-md-12'>
          <?php include('DescriptionBox.php'); ?>
        </div>
      </div>
    </div>



    <div class="col-md-2 col-xs-0 column">
    </div>

 </div>
</body>
</center>








<!--============================================================================

=============================================================================-->




<!--============================================================================
footer
=============================================================================-->
<?
include 'footer.php';
?>
