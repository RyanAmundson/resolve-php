



//===================================================================
//View Bar
//===================================================================


$(document).ready(function(){



  $(document).on('click','#viewbar-button1',function(){
    $('#ProfileDescription').show(300);
    $('#Description').hide(300);
    $('#ActivityDescription').hide(300);
  });
  $(document).on('click', '#viewbar-button2',function(){
    $('#Description').show(300);
    $('#ProfileDescription').hide(300);
    $('#ActivityDescription').hide(300);
  });
  $(document).on('click', '#viewbar-button3',function(){
    $('#ActivityDescription').show(300);
    $('#Description').hide(300);
    $('#ProfileDescription').hide(300);
  });












});
