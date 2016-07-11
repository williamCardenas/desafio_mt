$( document ).ready(function() {
  $("body").on("click","button[name='command']",function(){
    var server = $('.server').clone().html()+' ';
    $('<p>').html(server+$("input[name='command']").val()).appendTo('.terminal');
    var data = {
      command:$("input[name='command']").val()
    };
    $.ajax({
      url: "terminal/exec",
      type: "POST",
      dataType: 'json',
      data: data,
    })
    .done(function(response){
      $('<p>').html(server+response).appendTo('.terminal');
    })
    .fail();
  });
});
