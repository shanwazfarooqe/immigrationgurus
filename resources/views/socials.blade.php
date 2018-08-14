@extends('layouts.master')

@section('content')
<div class="content-wrapper">
  <div class="content-heading">
   <span><em class="fa fa-google-plus-square"></em> How did you find us options</span>
   <div class="pull-right"><button class="btn btn-info btn-sm" data-toggle="modal" data-target='#add_social' >Add new</button></div>
 </div>
 <div class="panel panel-default">
   <div class="panel-body">

    <div class="table-responsive">
      <table class="datatable table table-striped table-hover">
       <thead>
        <tr>
         <th>#</th>
         <th>Method</th>
         <th style="min-width: 100px;">Action</th>
       </tr>
     </thead>
     <tbody>
      @foreach($socials as $row)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $row->name }}</td>
        <td>
          <a data-toggle="modal" href='#edit_social' data-action="{{ route('socials.update',['id'=>$row->id]) }}" data-name="{{ $row->name }}" class="btn btn-info btn-xs">Edit</a>
          <button class="btn btn-danger btn-xs" onclick="deleteData({{ $row->id }})">Delete</button>
          <form action="{{ route('socials.destroy',['id'=>$row->id]) }}" method="post" id="form-delete{{ $row->id }}" style="display: none;">
          @csrf
          @method('delete')
          <input type="hidden" name="id" value="{{ $row->id }}">
          <button class="btn btn-danger" type="submit">Delete</button>
          </form>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>


</div>
</div>
</div>
@endsection

@section('custom_css')
<link rel="stylesheet" href="{{ asset('js/datatables/media/css/dataTables.bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('custom_js')
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
  <!-- Edit Social Modal-->
  @component('components.modal-visa')
    @slot('modal')
      edit_social
    @endslot
    @slot('method')
      @method('PUT')
    @endslot
    @slot('title')
      Edit method
    @endslot
    @slot('label')
      How did you find us?
    @endslot
    @slot('formid')
      edit-social
    @endslot
    @slot('action')
      javascript:void(0)
    @endslot
  @endcomponent
  <!-- Edit Social Modal JS-->
  <script>
    $("#edit_social").on('shown.bs.modal', function (e) {
        var action = $(e.relatedTarget).data('action');
        var name = $(e.relatedTarget).data('name');
        $('#edit-social').attr('action', action);
        $('#edit-social input[name="name"]').val(name);
    });
  </script>
  <!-- DATATABLES-->
  @component('components.table-js')
  @endcomponent
  <!-- Delete-->
  @component('components.status-delete-js')
  @slot('form')
      form-delete
  @endslot
  @slot('title')
      deleteData
  @endslot
  @endcomponent
  <!-- Add form submit-->
  @component('components.form-submit')
      @slot('form')
          create-social
      @endslot

      @slot('redirect')
          {{ route('socials.index') }}
      @endslot
  @endcomponent
  <!-- Edit form submit-->
  @component('components.form-submit')
      @slot('form')
          edit-social
      @endslot

      @slot('redirect')
          {{ route('socials.index') }}
      @endslot
  @endcomponent
@endsection