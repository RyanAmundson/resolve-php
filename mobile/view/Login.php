<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="FI" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black">


  <title>FI</title>
  <link href="../../bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../css/mobilestyle.css">
  <!-- <link rel="apple-touch-icon" href="apple-touch-icon-iphone.png">
  <link rel="apple-touch-icon" sizes="76x76" href="touch-icon-ipad.png">
  <link rel="apple-touch-icon" sizes="120x120" href="touch-icon-iphone-retina.png">
  <link rel="apple-touch-icon" sizes="152x152" href="touch-icon-ipad-retina.png"> -->
  <link rel="apple-touch-startup-image" href="startup.png">
  <link rel="apple-touch-icon" href="appicon.png">
  <link rel="icon" sizes="128x128" href="appicon.png">




  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<?php
if(isset($_SESSION['email'])){
  echo "logged in as: ". $_SESSION["email"];
  echo "<br><a href='logout.php'>Logout</a>";
  echo "<br><br><a href='contacts.php'>Contacts</a>";
}
$error = array();
include 'connection.php';
$mysqli = fConnectToDatabase();

#=================Redirect if sessions exists===================================
if(isset($_SESSION['email'])){
  header("location: index.php");
}
#================Check if fields are not empty==================================

#echo "<br>a",crypt('pw', "thisisthepasswordhash"),"a";
if(isset($_POST['email']) && isset($_POST['pw'])){

  $email = $_POST['email'];
  $pw = $_POST['pw'];
  $_POST = array();
  #$mysqli = new mysqli("104.236.55.220","generalUser","generaluser","FI");
  if($mysqli_connect_errno){
    echo "failed to connect to FI";
  }
  if ($stmt = mysqli_prepare($mysqli, "select firstname,lastname,id,email,password from FI.Users where email=?")) {
    mysqli_stmt_bind_param($stmt,'s',$email);
    if(!mysqli_stmt_execute($stmt)){
      echo "execute failed";
    }
    mysqli_stmt_bind_result($stmt, $fname,$lname, $uid,$e,$p);
    mysqli_stmt_fetch($stmt);

    if(!empty($e) && ($p == $pw)){
      #if (hash_equals($p, crypt($pw, "thisisthepasswordhash")) {
      #  echo "Password verified!";
      #}
      $_SESSION['fname'] = $fname;
      $_SESSION['lname'] = $lname;
      $_SESSION['uid'] = $uid;
      $_SESSION['email'] = $e;

      //echo '<script type="text/javascript"> Window.open("http://ryanamundson.com/APP513/mobile/view/index.php","fullscreen=yes"); Window.close(); </script>';
      header("Location: index.php");
      $stmt.close();
      mysqli_close($mysqli);

    } else {
      $error["invalid_login"] = "<div class='alert alert-warning' role='alert'>Invalid username or password</div>";
      //echo "<div class='alert alert-warning' role='alert'>Invalid username or password</div>";

    }
  }else{
    echo "failed to prepare";
  }

}
?>
<!--===========================================================================-->
<body class="container" id="loginpage">
<div class="row">
<div class="col-md-4"></div>
  <div id="loginbox" class="panel panel-body col-md-4">
    <h2>Login</h2>
    <form method="POST" id="loginform" >
      <div class="input-group input-group-sm">
        <span class="input-group-addon" id="sizing-addon3">Email</span>
        <input type="text" class="form-control" name="email" placeholder="Email" aria-describedby="sizing-addon3">
      </div>
      <br>

      <div class="input-group input-group-sm">
        <span class="input-group-addon" id="sizing-addon3">Password</span>
        <input type="password" name="pw" class="form-control" placeholder="Password" aria-describedby="sizing-addon3">
      </div>
      <br>
<?php
if(!empty($error['invalid_login'])){
  echo $error['invalid_login'];
}
?>
      <br>
      <button type="submit" value ="Login" class="btn btn-success">Login</button>
      <br><br><a href="CreateAccount.php">Create New Account<a>
    </form>
  </div>
<div class="col-md-4"></div>
</div>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="../../bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
