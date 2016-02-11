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
        switch(data.code){
          default:
          case 0:
          case 2:
            error(data);
          break;
          case 1:
            duplicate(data);
          break;
          case 3:
            success(data);
          break;
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
  $('.jumbotron').attr('class','jumbotron').addClass('progress-bar-success progress-bar-striped');
  $('h1').text(data.message);
  successSound.play();
  if (duplicateScan) {
    $('#ticketInfo').addClass('hide');
    duplicateScan = false;
  }
  //setTimeout(reset,5000);
}

function duplicate(data) {
  $('.jumbotron').attr('class','jumbotron').addClass('progress-bar-warning progress-bar-striped');
  $('h1').text(data.message);
  duplicateSound.play();
  $('#ticketInfo').removeClass('hide');
  $('#ticketInfo .panel-body').text('Scanned at: '+data.data.scanned_at+' by '+data.data.scanned_by);
  duplicateScan = true;
  //setTimeout(reset,5000);
}

function error(data) {
  $('.jumbotron').attr('class','jumbotron').addClass('progress-bar-danger progress-bar-striped');
  $('h1').text(data.message);
  errorSound.play();
  //setTimeout(reset,5000);
  if (duplicateScan) {
    $('#ticketInfo').addClass('hide');
    duplicateScan = false;
  }
}

function reset(){
  $('.jumbotron').removeClass('error').removeClass('success');
  $('h1').text("Ready to scan");
}
