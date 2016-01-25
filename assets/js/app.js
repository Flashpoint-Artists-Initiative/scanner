if ($('#username').val() == '') {
  $('#username').focus();
}

var successSound = document.getElementById('successSound');
var errorSound = document.getElementById('errorSound');

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
        if (0 == data.code){
          error(data.message);
        } else {
          success(data.message);
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

function success(message) {
  $('.jumbotron').addClass('success').removeClass('error');
  $('h1').text(message);
  successSound.play();
  //setTimeout(reset,5000);
}

function error(message) {
  $('.jumbotron').addClass('error').removeClass('success');
  $('h1').text(message);
  errorSound.play();
  //setTimeout(reset,5000);
}

function reset(){
  $('.jumbotron').removeClass('error').removeClass('success');
  $('h1').text("Ready to scan");
}
