if ($('#username').val() == '') {
  $('#username').focus();
}

var successSound = document.getElementById('successSound');
var errorSound = document.getElementById('errorSound');

var duplicateScan = false;

$('#ticket').keyup(function(e){
  console.log(e);
  var string = $(this).val();
  if(ticket_length == string.length) {
    if (''==$('#username').val()){
      $('.jumbotron').addClass('error').removeClass('success');
      $('h1').text('You must specify a username!');
    } else {
      var request = $.ajax({
        url: 'scan.php?user='+$('#username').val(),
        data: $(this).serialize(),
        method: 'POST',
        dataType: 'json'
      });
      request.done(function(data){
        console.log(data);
        if (data.code <= 2){
          error(data);
        } else if (data.code == 3){
          success(data);
        } else {
          error(data);
        }
      });
      request.fail(function(data){
        console.log(data);
        $('.debug').html(data.responseText);
      });
      $(this).val('');
    }
  }
});

function success(data) {
  $('.jumbotron').addClass('success').removeClass('error');
  $('h1').text(data.message);
  successSound.play();
  if (duplicateScan) {
    $('#ticketInfo').addClass('hide');
    duplicateScan = false;
  }
  //setTimeout(reset,5000);
}

function error(data) {
  $('.jumbotron').addClass('error').removeClass('success');
  $('h1').text(data.message);
  if (data.code == 1) {
    $('#ticketInfo').removeClass('hide');
    $('#ticketInfo .panel-body').text('Scanned at: '+data.data.scanned_at+' by '+data.data.scanned_by);
    duplicateScan = true;
  }
  errorSound.play();
  //setTimeout(reset,5000);
}

function reset(){
  $('.jumbotron').removeClass('error').removeClass('success');
  $('h1').text("Ready to scan");
}
