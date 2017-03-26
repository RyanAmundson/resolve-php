<?php
session_start();
include 'mobileheader.php';
?>
<?php
if(!isset($_SESSION["email"])){
  header("location: Login.php");
}

?>
<div id="myCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="0"></li>
    <li data-target="#myCarousel" data-slide-to="0"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <div class="media">


        <div id="mapholder"></div>
        <div class="media-body">
          <h4 class="media-heading">

          </h4>
          <div class="media">
            <a href="#" class="pull-left"><img src="" class="media-object" alt=""></a>
            <div class="media-body">
              <h4 class="media-heading">

              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="item">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">
            What
          </h3>
        </div>
        <div class="panel-body">

          <table id="purchase" class='table table-hover table-responsive table-condensed'>
            <th>What?</th><th>How Much?</th>

          </table>
          <button type="submit" onclick="addPurchase()" name="+">+</button>


        </div>
        <div class="panel-footer">
          Panel footer
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">
            <b>Who</b>
          </h3>(click on a contact to add them to the list)
        </div>
        <div class="panel-body">
          <h4>

          </h4>

          <table id="people" class='table table-hover table-responsive table-condensed'>
            <th>Who?</th><th>How Much?</th>

          </table>
          <button type="submit" onclick="submitTransaction()" name="submit">submit</button>







        </div>
        <div class="panel-footer">
          Panel footer
        </div>
      </div>
    </div>

    <div class="item">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">
            Contacts
          </h3>
        </div>
        <div class="panel-body">
          <?php
          $contacts = array();
          $id = $_SESSION['uid'];
          $sql = "select * from FI.contacts where uid='$id' and pending=0";
          $res = $mysqli->query($sql);
          $x = 0;
          if ($res->num_rows > 0) {
            echo "<table border='0'  class='table table-hover table-responsive table-condensed'>";

            while($row = mysqli_fetch_assoc($res)){

              $cid = $row['contactid'];

              $sql2 = "select * from FI.Users where id='$cid'";
              $res2 = $mysqli->query($sql2);
              $row2 = mysqli_fetch_assoc($res2);
              $fname = $row2['firstname'];
              $lname = $row2['lastname'];
              $uid = $row2['id'];

              $object = new stdClass();
              $object->uid = $uid;
              $object->id = $x;
              $object->fname = $fname;
              $object->lname = $lname;
              $contacts[] = $object;

              echo "<tr id='contactrow$x'><td>". $row2['firstname']." ".$row2['lastname']."</td></tr>";
              $x++;
              //onclick='createPerson(\"$fname\",\"$lname\",$x)'
            }
            //setcookie("contactCount", $x);
          }
          echo "</table><br>";
          echo "<script>var contacts = " . json_encode($contacts) . ';</script>';
          ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>








<?php
include 'footer.php';
?>

<script>
console.log(contacts);



var people = [];
window.onLoad = createPeople();

function createPeople(){
  for(var i = 0; i < contacts.length; i++){
    var x = contacts[i].id;
    //var person = {id:x, fname:contacts[i].fname, lname:contacts[i].lname};
    $('#contactrow'+x).click((function(x){ return function(){addPerson(x)};})(x));
  }
}

function addPerson(id){
  $(document).ready(function(){
    // jQuery methods go here...
    if($.inArray(id, people) == -1){
      $('#people').append("<tr id='row"+id+"'><td id='person"+id+"'>"+contacts[id].fname+" "+contacts[id].lname+"</td><td id='kp"+id+"'><input id='input"+id+"' type='number' value='0'></input></td></tr>");
      $('#person'+id).click(function(){removePerson(id)});
      $('#contactrow'+id).append("<span id='checkmark"+id+"' class='glyphicon glyphicon-ok' aria-hidden='true'></span>");
      people.push(id);
      //keypad(x);
    }
  });
}

function removePerson(id){
  console.log(id);
  $(document).ready(function(){
    // jQuery methods go here...
    console.log($.inArray(id, people) != -1);
    if($.inArray(id, people) != -1){
      $('#row'+id).remove();
      $('#checkmark'+id).remove();
      var index = people.indexOf(id);
      if (index > -1) {
        people.splice(index, 1);
      }
    }
  });
}




function submitTransaction(){


  var values = [];
  var total = 0;
  for(var i = 0; i < people.length; i++){
    //  console.log($("#input"+people[i]).val());
    values[i] = $("#input"+people[i]).val();
    total = total + parseInt(values[people[i]]);
  }
  var purchaseTotal = 0;
  for(var j = 0; j < purchases.length; j++){
    purchaseTotal = purchaseTotal + parseInt($("#purch"+j).val());

  }
  //console.log("purchase total = "+purchaseTotal);
  //console.log("contribution total = "+total);
  for(var k = 0; k < purchases.length; k++){
    //console.log($("#purchase"+k).val());

  }
  var val = "TransactionProfile.php?";
  document.cookie="total="+purchaseTotal.toString()+";";
  for(var q =0; q < people.length; q++){
    //console.log("p.id: " + contacts[people[q]].fname, "contrib: " + values[q]);
    //console.log($("#purchase"+q).val());
    //console.log($("#purch"+q).val());
    //var old_cookie = document.cookie;
    //document.cookie = old_cookie+' '+contacts[people[q]].fname +'='+values[q]+';';
    val = val+'&'+contacts[people[q]].uid +'='+values[q];
    //val = readCookie('total') +' '+ contacts[people[q]].fname +'='+values[q]+';';
    //createCookie('total',val,3000);

  }
  console.log(document.cookie);
  document.location.href = val;
  //console.log(people[0],people[1],people[2]);
  //console.log(values[0],values[1],values[2]);


}
var purchases = [];
var purchaseAmounts = [];
function addPurchase(){

  $('#purchase').append("<tr><td><input id='purchase"+purchases.length+"' type='text'></input></td><td><input id='purch"+purchaseAmounts.length+"' type='number' placeholder='Total Cost'></input></td></tr>");
  purchaseAmounts[purchaseAmounts.length] = "purch"+purchaseAmounts.length;
  purchases[purchases.length] = "purchase"+purchases.length;


}

function createCookie(name,value,days) {
  if (days) {
    var date = new Date();
    date.setTime(date.getTime()+(days*24*60*60*1000));
    var expires = "; expires="+date.toGMTString();
  }
  else var expires = "";
  document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
  var nameEQ = name + "=";
  var ca = document.cookie.split(';');
  for(var i=0;i < ca.length;i++) {
    var c = ca[i];
    while (c.charAt(0)==' ') c = c.substring(1,c.length);
    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
  }
  return null;
}

function eraseCookie(name) {
  createCookie(name,"",-1);
}



</script>
<script>
window.onload = getLocation();
var x = document.getElementById("demo");

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition, showError);
  } else {
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
  var latlon = position.coords.latitude + "," + position.coords.longitude;

  var img_url = "http://maps.googleapis.com/maps/api/staticmap?center="
  +latlon+"&zoom=15&size=300x300&sensor=false";
  document.getElementById("mapholder").innerHTML = "<img src='"+img_url+"'>";
}

function showError(error) {
  switch(error.code) {
    case error.PERMISSION_DENIED:
      x.innerHTML = "User denied the request for Geolocation."
      break;
      case error.POSITION_UNAVAILABLE:
        x.innerHTML = "Location information is unavailable."
        break;
        case error.TIMEOUT:
          x.innerHTML = "The request to get user location timed out."
          break;
          case error.UNKNOWN_ERROR:
            x.innerHTML = "An unknown error occurred."
            break;
          }
        }
        //==============================================================================
        </script>
