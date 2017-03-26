
<nav class="navbar navbar-default navbar-inverse navbar-fixed-top col-xs-12">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Home</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="UserProfile.php"><?php echo $_SESSION['fname']?> <span class="sr-only">(current)</span></a></li>
        <li><a href="contacts.php">Contacts</a></li>
        <li><a href="NotificationDisplay.php">Notifications <span class="badge"><?php checkTotal($uid, $mysqli); ?></span></a></li>
        <li id='hoverDD' class="dropdown carat" >

          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Messages</a></li>
            <li><a href="TransactionRequests.php">Transaction requests <span class="badge"><?php  echo checkTransactionRequests($uid, $mysqli);?></span></a></li>
            <li><a href="contacts.php?showRequests=1">Friend requests <span class="badge"><?php  echo checkContactRequests($uid, $mysqli);?></span></a></li>
            <li class="divider"></li>
            <li><a href="MyTransactions.php">My Transactions</a></li>
            <li class="divider"></li> -->

          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="Logout.php">Logout</a></li>
        <!-- <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Settings <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li class="divider"></li>
            <li><a href="#">Separated link</a></li>
          </ul>
        </li> -->
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<div style="margin-top:60px"></div>




                    <!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Notifications <span class="caret"><?php checkTotal($uid, $mysqli); ?></span></a>This makes dropdown work for old notification tab -->
