<div id="CashInput" class="panel panel-default">
  <div id ="CashInput-box-panel-header" class="panel-heading whitefont">
    <h3 class="panel-title">
      Create! <span class='glyphicon glyphicon-menu-down' aria-hidden='true'></span>
    </h3>
  </div>
  <!--<div style="background-image:url('http://maps.googleapis.com/maps/api/staticmap?center=40.756, -73.986&zoom=15&size=300x300&sensor=false')" class="panel-body">-->
  <div id ="CashInput-box-panel-body" class="panel-body" style='display:none'>
    <div class="wrap">
      <span>$<input class="maxwidth singlelineborder" type="text" pattern="[0-9]*" id="price" name="number"></span>
    </div>
  </div>
</div>


<script>


// $(document).ready(function(){
//   $("#CashInput-box-panel-header").click(function() {
//     $("#CashInput-box-panel-body").toggle();
//   });
// });
$(function(){
  // Set up the number formatting.

  $('#number_container').slideDown('fast');

  $('#price').on('change',function(){
    console.log('Change event.');
    var val = $('#price').val();
    $('#the_number').text( val !== '' ? val : '(empty)' );
  });

  $('#price').change(function(){
    var val = $('#price').val();

    $('#the_number').text( val !== '' ? val : '(empty)' );
  });

  $('#price').number( true, 2 );
});
</script>
