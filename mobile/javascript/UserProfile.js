
//===================================================================
//View Bar
//===================================================================


$(document).ready(function(){



  $(document).on('click','#viewbar-button1',function(){
    $('#MyCredit').show(300);
    $('#Recent').hide(300);
    $('#ActivityDescription').hide(300);
  });
  $(document).on('click', '#viewbar-button2',function(){
    $('#Recent').show(300);
    $('#MyCredit').hide(300);
    $('#ActivityDescription').hide(300);
  });
  $(document).on('click', '#viewbar-button3',function(){
    $('#ActivityDescription').show(300);
    $('#Recent').hide(300);
    $('#MyCredit').hide(300);
  });
});
