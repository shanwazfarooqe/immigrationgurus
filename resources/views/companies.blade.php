@extends('layouts.master')

@section('content')
<div class="content-wrapper">
  <div class="content-heading">
   <span><em class="fa fa-group"></em> Company</span>
   <div class="pull-right"><a href="{{ route('companies.register') }}" class="btn btn-sm btn-info"> Add Company </a></div>
 </div>
 <div class="panel panel-default">
   <div class="panel-body">

    <div class="table-responsive">
      <table class="datatable table table-striped table-hover">
       <thead>
        <tr>
         <th>#</th>
         <th>Company name</th>
         <th>Logo</th>
         <th>Contact no</th>
         <th>Email</th>
         <th>Status</th>
       </tr>
     </thead>
     <tbody>
      @foreach($users as $row)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $row->company_name }}</td>
        <td>
          <img src="{{ asset($row->logo) }}" alt="" style="width:70px;height:auto;">
        </td>
        <td>{{ $row->phone }}</td>
        <td>{{ $row->email }}</td>
        <td>
          <button class="btn btn-xs {{ ($row->status==1) ? 'btn-success' : 'btn-danger' }}" onclick="updateStatus({{ $row->id }})" {{ (Auth::id()==$row->id) ? 'disabled' : '' }}>{{ ($row->status==1) ? 'Active' : 'Inactive' }}</button>
          <form action="{{ route('teams.status') }}" method="post" id="form-status{{ $row->id }}" style="display: none;">
          @csrf
          @method('patch')
          <input type="hidden" name="id" value="{{ $row->id }}">
          <input type="hidden" name="status" value="{{ $row->status }}">
          <button class="btn btn-danger" type="submit">Status</button>
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
  <!-- DATATABLES-->
  @component('components.table-js')
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
@endsection