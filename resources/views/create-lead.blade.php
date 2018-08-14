@extends('layouts.master')

@section('content')
<div class="content-wrapper">

  <div class="content-heading">
   <span><i class="fa fa-group"></i> Add lead</span>
 </div>

 <div class="panel panel-default">
   <div class="panel-body">
    <form class="form-horizontal" action="{{ route('leads.store') }}" method="post" id="form" enctype="multipart/form-data">
    @csrf
     <div class="form-group">
       <div class="col-sm-4">
         <label class="control-label">
          First name
        </label>
        <input type="text" name="first_name" class="form-control" placeholder="First name">
      </div>
      <div class="col-sm-4">
       <label class="control-label">
         Last name
       </label>
       <input type="text" name="last_name" class="form-control" placeholder="Last name">
     </div>
     <div class="col-sm-4">
       <label class="control-label">
        Phone number
      </label>
      <input type="text" name="phone" class="form-control" placeholder="Phone number">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-4">
     <label class="control-label">
      Email
    </label>
    <input type="text" name="email" class="form-control" placeholder="Email">
  </div>
  <div class="col-sm-4">
   <label class="control-label">
    Address
  </label>
  <input type="text" name="address" class="form-control" placeholder="Address">
</div>
<div class="col-sm-4">
 <label class="control-label">
   Visa type
 </label>
 <div class="input-group">
   <select class="form-control select2-4" name="visa_id" id="visa_id">
     <option value="">Select</option>
     @foreach ($visas as $row)
       <option value="{{ $row->id }}">{{ $row->name }}</option>
     @endforeach
   </select>
   <span class="input-group-addon" data-toggle="modal" href='#add_visa' style="cursor: pointer;"><i class="fa fa-plus"></i></span>
 </div>
</div>
</div>

<div class="form-group">
 <div class="col-sm-4">
   <label class="control-label">
     Select organisation
   </label>
   <div class="input-group">
     <select class="form-control select2-4" name="organization_id" id="organization_id">
       <option value="">Select</option>
       @foreach ($organizations as $row)
         <option value="{{ $row->id }}">{{ $row->name }}</option>
       @endforeach
     </select>
     <span class="input-group-addon" data-toggle="modal" href='#add_org' style="cursor: pointer;"><i class="fa fa-plus"></i></span>
   </div>
 </div>
 <div class="col-sm-4">
   <label class="control-label">
    How did you find us?
  </label>
  <div class="input-group">
   <select class="form-control " id="select2-2" name="social_id">
     <option value="">Select</option>
     @foreach ($socials as $row)
       <option value="{{ $row->id }}">{{ $row->name }}</option>
     @endforeach
   </select>
   <span class="input-group-addon" data-toggle="modal" href='#add_social' style="cursor: pointer;"><i class="fa fa-plus"></i></span>
 </div>
</div>
<div class="col-sm-4">
 <label class="control-label">
  Assigned to
</label>
<select class="form-control select2-4" name="user_id">
 <option value="">Select</option>
 @foreach ($users as $row)
   <option value="{{ $row->id }}">{{ $row->first_name }} {{ $row->last_name }}</option>
 @endforeach
</select>
</div>
</div>

<div class="form-group">
 <div class="col-sm-12">
   <label class="control-label">  Notes</label>
   <textarea class="form-control" rows="2" placeholder="Type..." name="notes"></textarea>
 </div>
</div>
<div class="form-group">
  <div class="col-sm-4">
   <label class="control-label"> Upload profile photo </label>
   <input type="file" name="image" class="form-control filestyle" >
 </div>
</div>
<div class="form-group">
 <div class="col-sm-12">
  <div class="pull-right">
   <button class="btn btn-info btn-lg" type="submit">Submit</button>
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
  <!-- Add Visa Modal-->
  @component('components.modal-visa')
    @slot('modal')
      add_visa
    @endslot
    @slot('title')
    Add visa type
    @endslot
    @slot('label')
      Visa type
    @endslot
    @slot('formid')
      create-visa
    @endslot
    @slot('action')
    {{ route('visas.store') }}
    @endslot
  @endcomponent
  <!-- Add visa form submit-->
  @component('components.form-submit')
      @slot('form')
          create-visa
      @endslot

      if(data.status=="error")
      {
        $.notify(data.msg);
      }
      else
      {
        var visa = $('#create-visa input[name="name"]').val();
        $('#visa_id').append('<option value="'+data.id+'" selected>'+visa+'</option>');
        $('#add_visa').modal('hide');
        $.notify(data.msg,'success');
        $('#create-visa')[0].reset();
      }
  @endcomponent
  <!-- Add Social Modal-->
  @component('components.modal-visa')
    @slot('modal')
      add_social
    @endslot
    @slot('label')
      How did you find us?
    @endslot
    @slot('title')
      Add method
    @endslot
    @slot('formid')
      create-social
    @endslot
    @slot('action')
    {{ route('socials.store') }}
    @endslot
  @endcomponent
  <!-- Add social form submit-->
  @component('components.form-submit')
      @slot('form')
          create-social
      @endslot

      if(data.status=="error")
      {
        $.notify(data.msg);
      }
      else
      {
        var social = $('#create-social input[name="name"]').val();
        $('#select2-2').append('<option value="'+data.id+'" selected>'+social+'</option>');
        $('#add_social').modal('hide');
        $.notify(data.msg,'success');
        $('#create-social')[0].reset();
      }
  @endcomponent
  <!-- Add Organization Modal-->
  @component('components.modal-organisation')
  @endcomponent
  <!-- Organization form submit-->
  @component('components.form-submit')
      @slot('form')
          form-organization
      @endslot

      if(data.status=="error")
      {
        $.notify(data.msg);
      }
      else
      {
        var organization = $('#form-organization input[name="name"]').val();
        $('#organization_id').append('<option value="'+data.id+'" selected>'+organization+'</option>');
        $('#add_org').modal('hide');
        $.notify(data.msg,'success');
        $('#form-organization')[0].reset();
      }
  @endcomponent
  <!-- Lead form submit-->
  @component('components.form-submit')
      @slot('form')
          form
      @endslot

      @slot('redirect')
        {{ route('leads.index') }}
      @endslot
  @endcomponent
@endsection