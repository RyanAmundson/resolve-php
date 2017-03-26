

<?php
include_once 'connection.php';
include_once 'notifications.php';
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
  "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, minimal-ui">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="apple-mobile-web-app-capable" content="yes">



  <title>FI</title>

  <!--SCRIPTS-->

  <script src="../javascript/jquery-1.11.2.js"></script>
  <script src="http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.js"></script>


  <!--CSS-->
  <link href="../../bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../css/mobilestyle.css">
  <link rel="stylesheet" href="http://code.jquery.com/mobile/1.0.1/jquery.mobile-1.0.1.min.css" />

  <link src="../css/custom/jquery.mobile.custom.structure.min.css">
  <link src="//cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">
  <link src="../css/custom/jquery.mobile.custom.theme.min.css">

  <script type="text/javascript">
  $(document).ready(function(){
          // iOS web app full screen hacks.
          var a=document.getElementsByTagName("a");
          for(var i=0;i<a.length;i++) {
              if(!a[i].onclick && a[i].getAttribute("target") != "_blank") {
                  a[i].onclick=function() {
                          window.location=this.getAttribute("href");
                          return false;
                  }
              }
          }
  });
  </script>


  <!--<link rel="stylesheet" type="text/css" href="../css/style.css">-->
  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

  <![endif]-->
</head>
