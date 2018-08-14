@extends('layouts.master')

@section('content')
<div class="content-wrapper">
  <div class="content-heading">
   <span><em class="fa fa-cc-visa"></em> Visa type</span>
   <div class="pull-right"><button class="btn btn-info btn-sm" data-toggle="modal" data-target='#add_visa' >Add new</button></div>
 </div>
 <div class="panel panel-default">
   <div class="panel-body">

    <div class="table-responsive">
      <table class="datatable table table-striped table-hover">
       <thead>
        <tr>
         <th>#</th>
         <th>Visa type</th>
         <th style="min-width: 100px;">Action</th>
       </tr>
     </thead>
     <tbody>
      @foreach($visas as $row)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $row->name }}</td>
        <td>
          <a data-toggle="modal" href='#edit_visa' data-action="{{ route('visas.update',['id'=>$row->id]) }}" data-name="{{ $row->name }}" class="btn btn-info btn-xs">Edit</a>
          <button class="btn btn-danger btn-xs" onclick="deleteData({{ $row->id }})">Delete</button>
          <form action="{{ route('visas.destroy',['id'=>$row->id]) }}" method="post" id="form-delete{{ $row->id }}" style="display: none;">
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
  <!-- Edit Visa Modal-->
  @component('components.modal-visa')
    @slot('modal')
      edit_visa
    @endslot
    @slot('method')
      @method('PUT')
    @endslot
    @slot('title')
      Edit visa type
    @endslot
    @slot('label')
      Visa type
    @endslot
    @slot('formid')
      edit-visa
    @endslot
    @slot('action')
      javascript:void(0)
    @endslot
  @endcomponent
  <!-- Edit Visa Modal JS-->
  <script>
    $("#edit_visa").on('shown.bs.modal', function (e) {
        var action = $(e.relatedTarget).data('action');
        var name = $(e.relatedTarget).data('name');
        $('#edit-visa').attr('action', action);
        $('#edit-visa input[name="name"]').val(name);
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
          create-visa
      @endslot

      @slot('redirect')
          {{ route('visas.index') }}
      @endslot
  @endcomponent
  <!-- Edit form submit-->
  @component('components.form-submit')
      @slot('form')
          edit-visa
      @endslot

      @slot('redirect')
          {{ route('visas.index') }}
      @endslot
  @endcomponent
@endsection