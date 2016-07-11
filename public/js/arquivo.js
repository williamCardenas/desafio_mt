$( document ).ready(function() {
  $("body").on("click",".arquivo",function(){
    $('[name="id"]').val($(this).attr('arquivo-id'));
    $('[name="fileUpload"]').val('');
  });

  $("body").on("click",".novo-arquivo",function(){
    $('[name="id"]').val('');
    $('[name="fileUpload"]').val('');
  });
});
