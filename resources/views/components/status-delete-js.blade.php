<script>
  function {{ $title }}(id) {
    event.preventDefault();
    sweetAlert({
      title: "Are you sure?",
      /*text: "You will not be able to recover this banner!",*/
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes",
      cancelButtonText: "No",
      closeOnConfirm: true,
      closeOnCancel: false
    },
    function(isConfirm){
      if (isConfirm) {
        $('#{{ $form }}'+id).submit();
      } else {
          sweetAlert('Cancelled!', "", "success");
      }
    });
  }
</script>