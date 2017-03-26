<?php
$contacts = array();
$object = new stdClass();
$object->uid = $_SESSION['uid'];
$object->id = 0;
$object->fname = $_SESSION['fname'];
$object->lname = $_SESSION['lname'];
$contacts[] = $object;
$id = $_SESSION['uid'];
$sql = "select * from FI.contacts where uid='$id' and pending=0";
$res = $mysqli->query($sql);
$x = 1;


echo "<div class='panel panel-default' >
          <div id='contact-box-panel-header' class='panel-heading lightbluebg whitefont'>
            <h3 class='panel-title'>
              Invite People <span class='glyphicon glyphicon-menu-down' aria-hidden='true'></span>
            </h3>
          </div>
          <div id='contact-box-panel-body' style='display:none' class='panel-body'>";


//if ($res->num_rows > 0) {

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



                //onclick='createPerson(\"$fname\",\"$lname\",$x)'
	}
	echo "<table id='myTable'  class='table table-hover table-responsive table-striped table-bordered'>";
	echo "<thead><th>Name</th></thead>";
	echo"<tbody>";

	while($x < sizeof($contacts)){
		//echo "contacts: ".$contacts[$x]->uid;
		if($contacts[$x]->uid != $_SESSION['uid']){
			echo "<tr class='contact'><td class='contactrow' data-id='".$contacts[$x]->uid."'>". $contacts[$x]->fname." ".$contacts[$x]->lname."<a href='UserProfile.php?profileID=".$contacts[$x]->uid."' style='float:right' class='profilebutton btn btn-info btn-sm'>
          <span class='glyphicon glyphicon-user'></span>
        </a></td></tr>";
		}
		$x++;
	}

echo "</tbody></table>";
//}
echo "</div></div>";
//echo "<script>var contacts = " . json_encode($contacts) . ';</script>';

?>


<script>



$(document).ready(function(){
    $('#myTable').DataTable({
    });

    $("#contact-box-panel-header").click(function() {
      $("#contact-box-panel-body").toggle(100);
    });



});




</script>
