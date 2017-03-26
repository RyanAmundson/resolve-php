function plusTen(){
  var e1 = document.getElementsByName("amount"+x);
  e1[0].value = Number(e1[0].value) + 10;
}
function plusOne(){
  var e1 = document.getElementsByName("amount"+x);
  e1[0].value++;
}

function keypad(x){

  $("#kp"+x).append("<div id='numericInput' ><div id='numBox'></div><table id='keypad' ><tr><td class='key'>1</td><td class='key'>2</td><td class='key'>3</td></tr><tr><td class='key'>4</td><td class='key'>5</td><td class='key'>6</td></tr><tr><td class='key'>7</td><td class='key'>8</td><td class='key'>9</td></tr><tr><td class='button'>DEL</td><td class='key'>0</td><td class='button'>CLR</td></tr></table></div>");

  $(document).ready(function(){
    $('#numBox').click(function(){
      $('#keypad').fadeToggle('fast');
      event.stopPropagation();
    });


    // Function commented out
    // due to Chrome apparently being the
    // only browser smart enough to work
    // right >.<

    //$('body').click(function(){
    //    $('#keypad').fadeOut('fast');
    //    event.stopPropagation();
    //});

    $('.key').click(function(){
      var numBox = document.getElementById('numBox');
      if(this.innerHTML == '0'){
        if (numBox.innerHTML.length > 0)
          numBox.innerHTML = numBox.innerHTML + this.innerHTML;
        }
        else
          numBox.innerHTML = numBox.innerHTML + this.innerHTML;

          event.stopPropagation();
        });

        $('.btn').click(function(){
          if(this.innerHTML == 'DEL'){
            var numBox = document.getElementById('numBox');
            if(numBox.innerHTML.length > 0){
              numBox.innerHTML = numBox.innerHTML.substring(0, numBox.innerHTML.length - 1);
            }
          }
          else{
            document.getElementById('numBox').innerHTML = '';
          }

          event.stopPropagation();
        });
      });


      console.log("keypad");
      //$("#keypad").keypad();
    }



function showResult(str) {
  if (str.length==0) { 
    document.getElementById("livesearch").innerHTML="";
    document.getElementById("livesearch").style.border="0px";
    return;
  }
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else {  // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("livesearch").innerHTML=xmlhttp.responseText;
      document.getElementById("livesearch").style.border="1px solid #A5ACB2";
    }
  }
  xmlhttp.open("GET","livesearch.php?q="+str,true);
  xmlhttp.send();
}




    //cookie stuff
    //==============================================================================
    //
    //
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
    //
    //
    //==============================================================================
