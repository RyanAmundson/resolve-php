



//===================================================================
//View Bar
//===================================================================


$(document).ready(function(){



  $(document).on('click','#viewbar-button1',function(){
    $('#FriendRequests').show(300);
    $('#TransactionRequests').hide(300);
    $('#Messages').hide(300);
  });
  $(document).on('click', '#viewbar-button2',function(){
    $('#TransactionRequests').show(300);
    $('#Messages').hide(300);
    $('#FriendRequests').hide(300);
  });
  $(document).on('click', '#viewbar-button3',function(){
    $('#Messages').show(300);
    $('#TransactionRequests').hide(300);
    $('#FriendRequests').hide(300);
  });












});
