<!-- add organisation modal -->
<div class="modal fade" id="add_org">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add organisation</h4>
      </div>
      <form class="form-horizontal" action="{{ route('organizations.store') }}" method="post" id="form-organization" enctype="multipart/form-data">
      @csrf
      <div class="modal-body">
          <div class="form-group">
            <div class="col-sm-12">
            <label for="">Name</label>
            <input type="text" class="form-control" name="name" placeholder="Name">
            </div>
          </div>
          <div class="form-group">
             <div class="col-sm-12">
            <label for="">Address</label>
            <textarea rows="2" class="form-control" name="address" placeholder="type.."></textarea>
            </div>
          </div>
           <div class="form-group">
             <div class="col-sm-6">
            <label for="">Phone</label>
            <input type="text" class="form-control" name="phone" placeholder="Phone">
            </div>
             <div class="col-sm-6">
            <label for="">Email</label>
            <input type="text" class="form-control" name="email" placeholder="Email">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-12">
            <label for="">Website URL( Include http:// )</label>
            <input type="text" class="form-control" name="webiste" placeholder="Website URL">
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