



  var people = [];//position of person in contact list first is creator
  var purchases = [];//list of purchases
  var purchaseAmounts = [];//list of purhase amounts
  var numContacts;
  var numPeople = 0;
  var purchaseTotal= 0;
  var contacts;

  //===================================================================
  //TOUCH EVENTS
  //===================================================================

  /*$(document).on('pageinit', function(event){
    $(document).on("swipeleft",".wrap",function(event){
      console.log("left swipe");
    });
    $(".contact").on("tap",function(){
  	  console.log("tap");
    });
    $("div").on("swipe",function(){

       console.log("swipe");
    });
    $("tr").on("taphold",function(){
      console.log("taphold");

    });
  });*/

  //===================================================================
  // ADD OR REMOVE CHECKMARK AND EXISTENCE IN PEOPLE
  //===================================================================


$(document).ready(function(){
    $(document).on('click', '.contactrow',function(){
      $(this).toggleClass("success");
      $(this).toggleClass('ContactSelected');
      //$(this).toggle("<span id='checkmark"+id+"' style='margin:2px;' class='glyphicon glyphicon-ok' aria-hidden='true'></span>");


    });

});


  //===================================================================
  //SUBMITS THE TRANSACTION -MOBILE
  //===================================================================

$(document).ready(function(){

  $('.profilebutton').click(function(e) {
    e.stopPropagation();
});




    $(document).on('click', '#submitButton',function(){

      var selected =$(".ContactSelected").toArray();
      for(x in selected){selected[x] = selected[x].getAttribute('data-id');}


      var description = $('#description').val();
      numPeople = selected.length;
      var val = 0;
      val = $('#price').val();
      if(val == 0){
        alert("enter a price greater than 0!");
        return;
      }
      if(val%1 == 0){
        val = val + '.00';
      }
    purchaseTotal = val;
    contrib = 0;//per person contrib
		var url = "NewProfile.php?purchaseTotal="+purchaseTotal+"&numPeople="+numPeople;
    for(current in selected){
      setCookie(selected[current],contrib, 1);
      url = url+'&'+ selected[current] +'='+0;
    }
    var description = $('#DescriptionTextBox').val();
    console.log(description);


    setCookie("DescriptionBox",description, 1);
    console.log(getCookie("DescriptionBox"));
		console.log(url);
		document.location.href = url;
    });
  });

  //===================================================================
  //CONVERT TO FLOAT
  //===================================================================

  //$('#total').number( 1234, 2);

  //$('input[type="text"]').on('touchstart', function() {
  //$('#total').attr('type', 'number');
  //});
//
  //$('input[type="text"]').on('keydown blur', function() {
  //$('#total').attr('type', 'text');
  //});

  //
  // convertToFloat -
  //
  // param obj - This it the input box object
  // param event - This is the keyboard input allowing us to detect what key was pressed based on the ascii code
  // param decimal - The precision of decimal places I am rounding too
  //
  function convertToFloat(obj, event, decimal) {

  var value = obj.value.replace(/[^0-9.]/g,'');
  var ascii = event.which;
  var convertedNum = parseFloat(value);

  if (ascii == 8) { //backspace

    if (value == 0) {
      convertedNum = 0;
    } else {
      convertedNum = value/10;
    }
    // ascii codes between 48 and 57 are numbers
    //don't react to other keyboard inputs
    } else if (ascii >= 48 && ascii <= 57 && value < 1000000) {
      convertedNum = value*10;
    }

  obj.value = convertedNum.toFixed(decimal);
  return;
  }

  //===================================================================
  //contribute
  //===================================================================
  function contribute(){
    $(this).replaceWith('<h1>here</h1>');
  }
  //===================================================================
  //
  //===================================================================

  function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
  }


  //===================================================================
  //
  //===================================================================
  function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
  }
  //===================================================================
  //create and join toggle
  //===================================================================
  $(document).ready(function(){

    $("#CashInput-box-panel-header").click(function() {

      if($("#CI").hasClass("col-md-6 col-xs-6")){
        $('#JoinTransaction-box-panel-body').hide();
        $("#CI").removeClass();
        $("#JT").removeClass();
        $("#JT").hide();
        $("#CI").addClass("col-md-12 col-xs-12",200);
        $("#CashInput-box-panel-body").show(200);
      }else if($("#CI").hasClass("col-md-12 col-xs-12")){
        $('#JoinTransaction-box-panel-body').hide();
        $("#CashInput-box-panel-body").hide();
        $("#JT").addClass("col-md-6 col-xs-6");
        $("#CI").removeClass(200);
        $("#CI").addClass("col-md-6 col-xs-6",200);
        $("#JT").show(200);
      }

    });

    $("#JoinTransaction-box-panel-header").click(function() {

      if($("#JT").hasClass("col-md-6 col-xs-6")){
        $('#CashInput-box-panel-body').hide();
        $("#JT").removeClass();
        $("#CI").removeClass();
        $("#CI").hide();
        $("#JT").addClass("col-md-12 col-xs-12",200);
        $("#JoinTransaction-box-panel-body").show(200);
      }else if($("#JT").hasClass("col-md-12 col-xs-12")){
        $('#CashInput-box-panel-body').hide();
        $("#JoinTransaction-box-panel-body").hide();
        $("#CI").addClass("col-md-6 col-xs-6");
        $("#JT").removeClass(200);
        $("#JT").addClass("col-md-6 col-xs-6",200);
        $("#CI").show(200);
      }

    });
    $("#DescriptionBox-panel-header").click(function() {
      $("#DescriptionBox-panel-body").toggle(200);
    });
  });



  //===================================================================
  //
  //===================================================================
  //===================================================================
  //
  //===================================================================
