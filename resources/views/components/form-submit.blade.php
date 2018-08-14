<script>
  $('#{{ $form }}').submit(function(event) {
    event.preventDefault();
    var form = document.getElementById('{{ $form }}');
    fd = new FormData(form);
    $.ajax({
      url: $(this).attr('action'),
      type: 'POST',
      dataType: 'json',
      data: fd,
      processData: false,
      contentType: false
    })
    .done(function(data) {
      @isset ($redirect)
        if(data.status=="error")
        {
          $.notify(data.msg);
        }
        else
        {
          sweetAlert({
             title:'Success!',
             text: data.msg,
             type:'success'
           },
           function(isConfirm){
              location.href="{{ $redirect }}";
            });
        }
      @else
        {{ $slot }}
      @endisset
    });

  });
</script>