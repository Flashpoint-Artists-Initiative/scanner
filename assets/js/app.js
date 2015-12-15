var ticket_id_length = 10;

$(document).ready(function(){
  $('#ticket').focus();
});

$('#ticket').keyup(function(e){
  console.log(e);
  var string = $(this).val();
  if(ticket_id_length == string.length) {
    if (''==$('#username').val()){
      $('body').addClass('error').removeClass('success');
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
          $('body').addClass('error').removeClass('success');
          $('h1').text(data.msg);
        } else {
          $('body').addClass('success').removeClass('error');
          $('h1').text(data.msg);
        }
      });
      request.fail(function(data){
        console.log(data);
      });
      $(this).val('');
    }
  }
});
