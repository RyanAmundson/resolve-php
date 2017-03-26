<?php
session_start();


include 'mobileheader.php';
include 'validate.php';
$mysqli = fConnectToDatabase();

$error = array();

/*
-Grab values from POST and validate
-set errors while validating
*/
if(isset($_POST['submit'])){

  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $pw = $_POST['pw'];
  $repw = $_POST['repw'];
   // $error['empty_fields'] = "<div class='alert alert-danger' role='alert'>Oops! Some of the fields are empty!</div>" ;
  

    
  $error['fname'] = validateName($fname); 

  $error['lname'] = validateName($lname);

  $error['email'] = validateEmail($email);

  if(!($pw == $repw)){
    //echo "<br>those passwords dont match!";
    $error['mismatch_passwords'] = "<div class='alert alert-danger' role='alert'>Those passwords don't match!</div>";
    $error['empty'] = 0;
  }


  if($mysqli_connect_errno){
    echo "failed to connect to FI";
  }
  if(!($stmt = mysqli_prepare($mysqli, "select email from FI.Users where email=?"))){
    echo "<br>Failed to prepare";
  }

  if(!mysqli_stmt_bind_param($stmt,'s',$email)){
    echo "<br>failed to bind params";
  }

  if(!mysqli_stmt_execute($stmt)){
    echo "<br>execute failed";
  }

  mysqli_stmt_bind_result($stmt, $e);

  mysqli_stmt_fetch($stmt);

  if(!empty($e)){
    //echo "<br>that account email is already registered!";
    $error['already_registered'] = "<div class='alert alert-danger' role='alert'>That account already exists! <a href='Login.php'>login?</a></div>";

  } else {

    $sql = "insert into FI.Users(firstname,lastname,password,email) values (?,?,?,?)";
    if($insertstmt = mysqli_prepare($mysqli,$sql)){

      $insertstmt->bind_param('ssss',$fname,$lname,$pw,$email);
      $insertstmt->execute();
      echo "<br>Account created!";
      $stmt->close();
      $insertstmt->close();
      mysqli_close($mysqli);
      header('Location: Login.php');
    }else{
      $error['empty_fields'] = "<div class='alert alert-danger' role='alert'>Failed to create account. The database may be down!</div>";
    }
    $_POST = array();
  }
}
#===============================================================================
$_POST = array();
?>

<body class="container">
  <div class="row">
  <div class="col-md-4"></div>
  <div id="create-account" class="panel panel-body col-md-4">
    <form  role="form" method="POST" class="form-group">
      <h2>Create Account</h2>
      <br>
      <input id="usr" type="text" class="form-control" name="fname" placeholder="First Name" value="<?php echo $fname;?>">
      <br>
      <?php echo $error['fname'];?>
      <br>
      <input id="" type="text" class="form-control" name="lname" placeholder="Last Name" value="<?php echo $lname;?>">
      <br>
      <?php echo $error['lname'];?>
      <br>
      <input id="" type="text" class="form-control" name="email" placeholder="Email" value="<?php echo $email;?>">
      <br>
      <?php echo $error['email'];?>
      <br>
      <input id="" type="password" class="form-control" name="pw" placeholder="Password" value="<?php echo $pw;?>">
      <br>
      <br>
      <input id="" type="password" class="form-control" name="repw" placeholder="Re-enter Password" value="<?php echo $repw;?>">
      <br>
      <?php
        if(empty($error['mismatch_passwords']) && empty($error['lname']) && empty($error['fname']) && empty($error['email'])){
          echo $error['empty_fields']."<br>";
          echo $error['already_registered'];
        }else{
          echo $error['mismatch_passwords'];
        }
      ?>

      <button type="submit" name="submit" value="submit" class="btn btn-success">Create!</button>
      <br>
      <br>
      <a href = "Login.php">Back to Login</a>

    </form>
  </div>
  <div class="col-md-4"></div>
</div>



</body>

<?php
include 'footer.php';
#if (hash_equals($p, crypt($pw, "thisisthepasswordhash")) {
#  echo "Password verified!";
#}

#echo "<br>a",crypt('pw', "thisisthepasswordhash"),"a";
?>
