@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    
    <div class="content-heading">
       <span><em class="fa fa-group"></em> Add organisation</span> 
    </div>

    <div class="panel panel-default">
       <div class="panel-body">

      <form class="form-horizontal" action="{{ route('organizations.store') }}" method="post" id="form" enctype="multipart/form-data">
      @csrf
            <div class="form-group">
               <div class="col-sm-6">
                  <label class="control-label">
                     Name
                  </label>
                  <input type="text" name="name" class="form-control" placeholder="Name">
               </div>
              <div class="col-sm-6">
                  <label class="control-label">
                     Phone No
                  </label>
                  <input type="text" name="phone" class="form-control" placeholder="Phone No">
               </div>
            </div>

            <div class="form-group">
               <div class="col-sm-6">
              <label for="">Email</label>
              <input type="text" class="form-control" name="email" placeholder="Email">
              </div>
               <div class="col-sm-6">
              <label for="">Website URL( include:http:// )</label>
              <input type="text" class="form-control" name="website" placeholder="Website URL">
              </div>
            </div>
             <div class="form-group">
              <div class="col-sm-12">
                 <label class="control-label">
                    Address
                 </label>
                 <textarea name="address" class="form-control" placeholder="Address"></textarea>
              </div>
              <div class="col-sm-12">
               <label class="control-label">
                  Logo
                </label>
                <input type="file" name="logo" class="filestyle">
              </div>
             </div>
              <div class="form-group">
               
                 <div class="col-sm-12">
                  <div class="pull-right">
                   <button class="btn btn-lg btn-info" type="submit">Submit</button>
                  </div>  
                </div>
             </div>
             
        </form>

       </div>
    </div>
</div>
@endsection

@section('custom_js')
  <script src="{{ asset('js/bootstrap-filestyle.js') }}"></script>
  @component('components.form-submit')
      @slot('form')
          form
      @endslot

      @slot('redirect')
        {{ route('organizations.index') }}
      @endslot
  @endcomponent
@endsection