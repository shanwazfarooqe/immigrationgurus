@if ($errors->any())
  <div class="alert alert-warning">
    <strong><i class="fa fa-warning"></i></strong> {{ $errors->all()[0] }}
  </div>
@endif