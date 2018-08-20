@extends('layouts.master')

@section('content')
<div class="content-wrapper">
  <div class="content-heading">
   <span><em class="fa fa-file-o"></em> Forms Data</span>
   <div class="pull-right"><a href="{{ route('forms.index') }}" class="btn btn-sm btn-info"> Form List </a></div>
 </div>
 <div class="panel panel-default">
   <div class="panel-body">

    <div class="table-responsive">
      <table class="datatable table table-striped table-hover">
       <thead>
        <tr>
         <th>#</th>
         <th>Category</th>
         <th>Created by</th>
         <th>Created date</th>
         <th style="min-width: 100px;">Action</th>
       </tr>
     </thead>
     <tbody>
      @foreach($category->form_datas->unique('unique_id') as $row)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $category->name }}</td>
        <td>{{ $row->user->first_name }} {{ $row->user->last_name }}</td>
        <td>{{ $row->created_at->format('d/m/Y h:i:s a') }}</td>
        <td>
          <a href="{{ route('forms.data',['id'=>base64_encode($row->id)]) }}" class="btn btn-info btn-xs">View</a>
          {{-- <button class="btn btn-danger btn-xs" onclick="deleteData({{ $row->id }})">Delete</button>
          <form action="{{ route('organizations.destroy',['id'=>$row->id]) }}" method="post" id="form-delete{{ $row->id }}" style="display: none;">
          @csrf
          @method('delete')
          <input type="hidden" name="id" value="{{ $row->id }}">
          <button class="btn btn-danger" type="submit">Delete</button>
          </form> --}}
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
@endsection