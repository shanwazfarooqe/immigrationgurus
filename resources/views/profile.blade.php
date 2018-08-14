@extends('layouts.master')

@section('content')
<div class="content-wrapper">
  <div class="content-heading text-center">
   Profile Settings
 </div>
 <div class="panel widget">
   <div style="background-image: url('{{ asset('img/login-bg.jpg') }}')" class="panel-body text-center bg-center">
    <div class="row row-table">
     <div class="col-xs-12 text-white">
      <img src="{{ (file_exists(Auth::user()->image)) ? asset(Auth::user()->image) : asset('img/user/8.jpg') }}" alt="Image" class="img-thumbnail img-circle thumb128" id="blah">
      <label for="fileToUpload" class="center-block" style="margin-top:-30px; cursor:pointer">
        <em class="icon-camera" style="color:#2db7e5; font-size:24px;"></em>
      </label>
      <input type="File" name="fileToUpload" id="fileToUpload" style="display: none;" onChange="readURL(this);">
      <h3 class="m0">

          {{ (Auth::user()->company_name) ? Auth::user()->company_name : Auth::user()->first_name . ' ' . Auth::user()->last_name }}
      </h3>
      <p class="m0">
       <em class="fa fa-twitter fa-fw"></em>{{ Auth::user()->email }}</p>
     </div>
   </div>
 </div>

 <div role="tabpanel">
   <div class="panel-body text-center bg-gray-darker bg-setting">
     <!-- Nav tabs-->

     <ul role="tablist" class="nav nav-tabs nav-tabss">
      <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"> <em class="icon-user"></em> &nbsp; Manage profile</a>
      </li>
      <li role="presentation"><a href="#add" aria-controls="add" role="tab" data-toggle="tab"><em class="icon-lock"></em> &nbsp; Change password</a>
      </li>
    </ul>
    <!-- Tab panes-->
  </div>
  <div class="tab-content sds">
    <div id="home" role="tabpanel" class="tab-pane active">
      <form method="post" action="{{ route('profile.update') }}" class="form-horizontal" id="form-profile" enctype="multipart-formdata">
      @csrf
      @method('PUT')

      <input type="hidden" name="id" value="{{ Auth::id() }}">

      @if(Gate::check('isCompany') || Gate::check('isSuperAdmin')) 
         <div class="form-group">
           <div class="col-sm-6 col-sm-offset-3">

            <label class="control-label"> Company name</label>
            <input type="text" name="company_name" class="form-control" placeholder="Company name" value="{{ Auth::user()->company_name }}">
          </div>
        </div>
      @endif

       <div class="form-group">
         <div class="col-sm-3 col-sm-offset-3">

          <label class="control-label"> First name</label>
          <input type="text" name="first_name" class="form-control" placeholder="First name" value="{{ Auth::user()->first_name }}">
        </div>
         <div class="col-sm-3">
          <label class="control-label"> Last name</label>
          <input type="text" name="last_name" class="form-control" placeholder="Last name" value="{{ Auth::user()->last_name }}">
        </div>
      </div>


      <div class="form-group">
       <div class="col-sm-3 col-sm-offset-3">
         <label class="control-label">Email</label>
         <input type="text" name="email" class="form-control" placeholder="Email" value="{{ Auth::user()->email }}">
       </div>
     @if(Gate::check('isCompany') || Gate::check('isSuperAdmin')) 
       <div class="col-sm-3">
        <label class="control-label">
           Logo
         </label>
         <input type="file" name="logo" class="form-control filestyle">
       </div>
     @endif
     </div>
<hr>
      <div class="form-group">
       <div class="col-sm-4 col-sm-offset-5">
          <div class="btn-group">
            <button type="submit" class="btn btn-success">Update</button>
            <button type="reset" class="btn btn-primary">Reset</button>
          </div>
        </div>
      </div>
  </form>
</div>

<div id="add" role="tabpanel" class="tab-pane">
  <form method="post" action="{{ route('profile.updatepassword') }}" class="form-horizontal" id="form-password">
  @csrf
  <input type="hidden" name="id" value="{{ Auth::id() }}">
    <div class="form-group">
     <div class="col-sm-6 col-sm-offset-3">
       <label class="control-label">New Password</label>
       <input type="password" name="password" class="form-control" placeholder="*********">
     </div>
   </div>
   <div class="form-group">
     <div class="col-sm-6 col-sm-offset-3">
       <label class="control-label">Confirm New Password</label>
       <input type="password" name="password_confirmation" class="form-control" placeholder="*********">
     </div>
   </div>

   <fieldset>
    <div class="form-group">
     <div class="col-sm-4 col-sm-offset-5">
      <button type="submit" class="btn btn-primary">Update Password</button>
    </div>
  </div>
</fieldset>
</form>
</div>

</div>
</div>
</div>
</div>
@endsection

@section('custom_css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('custom_js')
  <script src="{{ asset('js/bootstrap-filestyle.js') }}"></script>
  <script>
    function updateStatus(id) {
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
          $('#form-status'+id).submit();
        } else {
            sweetAlert('Cancelled!', "", "success");
        }
      });
    }
  </script>
  <script >
     function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);

            var fd = new FormData();
            fd.append( 'id', {{ Auth::id() }} ); 
            fd.append( 'file', input.files[0] );
            fd.append( '_token', '{{ csrf_token() }}' );

            $.ajax({
              url: '{{ route('profile.image') }}',
              data: fd,
              processData: false,
              contentType: false,
              type: 'POST',
              dataType: 'json',
              success: function(data){
                if(data.status=="error")
                {
                  $.notify(data.msg);
                  $('#blah').attr('src', '{{ (file_exists(Auth::user()->image)) ? asset(Auth::user()->image) : asset('img/user/8.jpg') }}');
                }
              }
            });
        }
    }
  </script>
  @component('components.form-submit')
      @slot('form')
          form-password
      @endslot

      if(data.status=="error")
      {
        $.notify(data.msg);
      }
      else
      {
        $.notify(data.msg,'success');
      }
  @endcomponent
  @component('components.form-submit')
      @slot('form')
          form-profile
      @endslot

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
            location.reload();
          });
      }
  @endcomponent
@endsection