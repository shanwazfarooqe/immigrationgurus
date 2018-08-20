@extends('layouts.master')

@section('content')
<div class="content-wrapper">

  <div class="content-heading ">
    Templates <i class="fa fa-object-group"></i> 

  </div>
  <div class="panel panel-default">
   <div class="panel-body">
    <div class="container-fluid">
      <div class="row">
       <div class="col-sm-3" >
        <div class="card-body" style="padding: 33px 0px;">

          <ul class="side-list" style="-webkit-padding-start: 20px;">
           <li> <button class="btn btnc btn-primary" data-toggle="modal" data-target="#myModal-create-Template">
             New Templates  <i class="fa fa-object-group"></i></button></li>
            @foreach($modules as $mod)
             <li><i class="fa fa-angle-right"></i> <a href="{{ route('templates.detail',['id'=>base64_encode($mod->id)]) }}" @if(!$id) {{ ($loop->first) ? 'class=tabactive' : '' }} @else {{ ($id==$mod->id) ? 'class=tabactive' : '' }}  @endif>{{ $mod->name }}{{-- <i class="fa icon-people"></i> --}}</a></li>
            @endforeach
           </ul>
         </div>
       </div>
       <div class="col-sm-9" style="padding-left: 0px;">
         <div class="card-body" style="padding: 33px 0px;">



           <table class="table table-hover mb-mails">
            <thead>
              <tr>
                <th colspan="3">@if($module) {{ $module->name }} @endif</th>
                <th  class="text-center">MODIFIED BY</th>
                <th  class="text-center" style="min-width: 95px">ACTION</th>
              </tr>
            </thead>
            <tbody>
            @if(!empty($templates))
            @foreach($templates as $template)
              <tr>

               <td>
                <div class="checkbox c-checkbox">
                 <label>
                  <input type="checkbox">
                  <span class="fa fa-check"></span>
                </label>
              </div>
            </td>

            <td class="text-center checkbox-star attachment_icon">
             <input type="checkbox" id="starhalf{{ $template->id }}" onclick="updateFavorite({{ $template->id }})" @if($template->user_id==Auth::id() && $template->favorite==1) checked="" @endif /><label class="half" for="starhalf{{ $template->id }}" >
               <em class="fa fa-star"></em>
             </label>
             <form action="{{ route('templates.favorite',['id'=>$template->id]) }}" method="post" id="form-favorite{{ $template->id }}" style="display: none;">
             @csrf
             @method('put')
             <input type="hidden" name="id" value="{{ $template->id }}">
             <input type="hidden" name="favorite" value="{{ $template->favorite }}">
             </form>
           </td>
           <td>
             <div class="mb-mail-meta profile-pic">
               <div class="pull-left">
                <div class="mb-mail-subject">{{ $template->name }}</div>
              </div>
              <div class="mb-mail-preview">{{ $template->subject }}</div>
              {{-- <div class="edit"><a href="JavaScript:void(0)"><i class="fa fa-pencil fa-lg"></i></a></div> --}}
            </div>
          </td>
          <td class="text-center">
            <div class="mb-mail-from"> {{ $template->user->first_name }} {{ $template->user->last_name }}</div>
            <small>{{ $template->updated_at }}</small>
          </td>
          <td class="text-center"><a href="#" class="btn btn-info btn-xs"  data-toggle="modal" data-target="#myModal-edit-Template" data-action="{{ route('templates.update',['id'=>$template->id]) }}" data-name="{{ $template->name }}" data-module_id="{{ $template->module_id }}" data-subject="{{ $template->subject }}"><i class="fa fa-edit"></i></a>
            <a href="javascript:void(0)" class="btn btn-danger btn-xs" @if($template->user_id==Auth::id()) onclick="updateStatus({{ $template->id }})" @else disabled="" @endif><i class="fa fa-trash"></i></a>
            <form action="{{ route('templates.status',['id'=>$template->id]) }}" method="post" id="form-status{{ $template->id }}" style="display: none;">
            @csrf
            @method('put')
            <input type="hidden" name="id" value="{{ $template->id }}">
            <input type="hidden" name="status" value="{{ $template->status }}">
            </form>
          </td>
        </tr>
        @endforeach
        @else
        <tr><td colspan="5">No data to display</td></tr>
        @endif
</tbody>
</table>

</div>
</div>
</div>

</div>

</div>
</div>

</div>
@endsection

@section('custom_css')
<style type="text/css">
   .table thead th {
       font-weight: 600;
       background-color: #eeefee;
       color: #212b31;
       vertical-align: bottom;
       border-bottom: 2px solid #c2cfd6;
     }
     .mb-mails td {
       vertical-align: middle;
       border-bottom: 1px solid #e4eaec;
   }
   .mb-mails > tbody > tr > td {
       border-top-color: transparent;
       cursor: pointer;
   }
   .checkbox-star input[type=checkbox] {
       display: none;
   }
   .checkbox-star em {
       font-size: 24px;
   }
   .checkbox-star input[type="checkbox"]:checked+label {
       color: #FFBD0B;
   }
   .checkbox-star label {
     cursor: pointer;
     color: #9fb4bd;
 }
 a.tabactive {
  color: #8ec640;
 }
 </style>
@endsection

@section('custom_js')
<!-- Modal for create Template-->
<div class="modal fade" id="myModal-create-Template" role="dialog">
  <div class="modal-dialog modal-md ">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> <i class="fa fa-object-group"></i> Create new template</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form action="{{ route('templates.store') }}" method="POST" role="form" class="form-horizontal" id="template-form">
      @csrf
        <div class="modal-body">
          <div class="form-group row">
           <div class="col-sm-12">
            <label for="name">Select module</label>
            <div class="input-group m-b">
              <select  class="form-control" name="module_id" id="module_id">
                <option value="">Select</option>
                @foreach ($modules as $row)
                  <option value="{{ $row->id }}">{{ $row->name }}</option>
                @endforeach
              </select>
              <span class="input-group-addon" data-toggle="modal" data-target="#add_modulem"><em class="fa fa-edit" style="cursor: pointer;"></em></span>
            </div>
          </div>
        </div>
        <div class="form-group row">
         <div class="col-sm-12">
          <label class=" control-label">Template name</label>
          <div class="input-group m-b">
           <input type="text" class="form-control" placeholder="Template name" name="name"> 
           <span class="input-group-addon"><em class="icon-menu"></em></span>
         </div>
       </div>
     </div>

     <div class="form-group row">
       <div class="col-sm-12">
         <label class=" control-label">Template subject</label>
         <div class="input-group m-b">
           <input type="text" class="form-control" placeholder="Template subject" name="subject"> 
           <span class="input-group-addon"><em class="icon-menu"></em></span>
         </div>
       </div>
     </div>

   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-info">Next</button>
  </div>
</form>

</div>
</div>
</div>

<!-- Modal for Edit Template-->
<div class="modal fade" id="myModal-edit-Template" role="dialog">
  <div class="modal-dialog modal-md ">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> <i class="fa fa-object-group"></i> Edit template</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form action="#" method="POST" role="form" class="form-horizontal" id="template-edit-form">
      @csrf
      @method('PUT')
        <div class="modal-body">
          <div class="form-group row">
           <div class="col-sm-12">
            <label for="name">Select module</label>
            <div class="input-group m-b">
              <select  class="form-control" name="module_id" id="module_id">
                <option value="">Select</option>
                @foreach ($modules as $row)
                  <option value="{{ $row->id }}">{{ $row->name }}</option>
                @endforeach
              </select>
              <span class="input-group-addon" data-toggle="modal" data-target="#add_modulem"><em class="fa fa-edit" style="cursor: pointer;"></em></span>
            </div>
          </div>
        </div>
        <div class="form-group row">
         <div class="col-sm-12">
          <label class=" control-label">Template name</label>
          <div class="input-group m-b">
           <input type="text" class="form-control" placeholder="Template name" name="name"> 
           <span class="input-group-addon"><em class="icon-menu"></em></span>
         </div>
       </div>
     </div>

     <div class="form-group row">
       <div class="col-sm-12">
         <label class=" control-label">Template subject</label>
         <div class="input-group m-b">
           <input type="text" class="form-control" placeholder="Template subject" name="subject"> 
           <span class="input-group-addon"><em class="icon-menu"></em></span>
         </div>
       </div>
     </div>

   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-info">Next</button>
  </div>
</form>

</div>
</div>
</div>

<!-- Module modal -->
<div class="modal fade" id="add_modulem">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add new module</h4>
      </div>
      <form action="{{ route('templates.module') }}" method="POST" role="form" class="form-horizontal" id="module-form">
      @csrf
        <div class="modal-body">
          <div class="form-group">
            <div class="col-sm-12">
              <label for="">Add Module</label>
              <input type="text" class="form-control" name="module" placeholder="Type...">
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
  <!-- Module Submit -->
  @component('components.form-submit')
      @slot('form')
          module-form
      @endslot

      if(data.status=="error")
      {
        $.notify(data.msg);
      }
      else
      {
        var module = $('#module-form input[name="module"]').val();
        $('#module_id').append('<option value="'+data.id+'" selected>'+module+'</option>');
        $('#add_modulem').modal('hide');
        $.notify(data.msg,'success');
        $('#module-form')[0].reset();
      }
  @endcomponent
  <!-- Template Submit -->
  @component('components.form-submit')
      @slot('form')
          template-form
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
            location.href=data.redirect;
          });
      }
  @endcomponent

  <!-- Edit Task Modal JS-->
  <script>
    $("#myModal-edit-Template").on('shown.bs.modal', function (e) {
        var action = $(e.relatedTarget).data('action');
        var module_id = $(e.relatedTarget).data('module_id');
        var name = $(e.relatedTarget).data('name');
        var subject = $(e.relatedTarget).data('subject');
        $('#myModal-edit-Template form').attr('action', action);
        $('#myModal-edit-Template [name="module_id"]').val(module_id);
        $('#myModal-edit-Template [name="subject"]').val(subject);
        $('#myModal-edit-Template [name="name"]').val(name);
    });
  </script>

  <!-- Template Submit -->
  @component('components.form-submit')
      @slot('form')
          template-edit-form
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
            location.href=data.redirect;
          });
      }
  @endcomponent
  <!-- Status-->
  @component('components.status-delete-js')
  @slot('form')
      form-status
  @endslot
  @slot('title')
      updateStatus
  @endslot
  @endcomponent
  <!-- Status-->
  @component('components.status-delete-js')
  @slot('form')
      form-favorite
  @endslot
  @slot('title')
      updateFavorite
  @endslot
  @endcomponent

@endsection