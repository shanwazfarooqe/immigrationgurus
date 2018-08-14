<!-- add Visa type modal -->
<div class="modal fade" id="{{ $modal }}">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">{{ $title }}</h4>
      </div>
      <form action="{{ $action }}" method="POST" role="form" class="form-horizontal" id="{{ $formid }}">
      @csrf
      @isset($method)
        {{ $method }}
      @endisset
      
      <div class="modal-body">
          <div class="form-group">
            <div class="col-sm-12">
            <label for="">{{ $label }}</label>
            <input type="text" class="form-control" name="name" placeholder="{{ $label }}">
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-info">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>