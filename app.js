$(document).ready(function(){
  $('input').focus();
});

$('input').keyup(function(e){
  console.log(e);
  var string = $(this).val();
  if(10 == string.length) {
    var request = $.ajax({
      url: 'scan.php',
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

    })
    $(this).val('');
  }
})
