@extends('layouts.master')

@section('content')
<div class="content-wrapper">
  <div class="content-heading">
   <span><em class="fa fa-group"></em> Customers</span>
 </div>
 <div class="panel panel-default">
   <div class="panel-body">

    <div class="table-responsive">
      <table class="datatable table table-striped table-hover">
       <thead>
        <tr>
         <th>#</th>
         <th>First name</th>
         <th>Last name</th>
         <th>Phone</th>
         <th>Email</th>
         <th>Organization</th>
         <th>Visa type</th>
         <th>Qualification</th>
         <th style="min-width: 100px;">Action</th>
       </tr>
     </thead>
     <tbody>
      @foreach($leads as $row)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $row->first_name }}</td>
        <td>{{ $row->last_name }}</td>
        <td>{{ $row->phone }}</td>
        <td>{{ $row->email }}</td>
        <td>
          <select class="form-control select2-4" name="organization_id" id="organization_id" onchange="setOrganization(this,{{ $row->id }});">
            <option value="">Select</option>
            @foreach ($organizations as $org)
              <option value="{{ $org->id }}" {{ ($org->id==$row->organization_id)? 'selected' : '' }}>{{ $org->name }}</option>
            @endforeach
          </select>
        </td>
        <td>
          @if($row->visa_id) {{ $row->visa->name }} @endif
        </td>
        <td>
          @if($row->status==1)
            Prequalify
          @elseif($row->status==2)
            Qualify
          @else
            
          @endif
        </td>
        <td>
          {{-- <a href="{{ route('leads.edit',['id'=>base64_encode($row->id)]) }}" class="btn btn-info btn-xs">Edit</a> --}}
          <a href="{{ route('leads.show',['id'=>base64_encode($row->id)]) }}" class="btn btn-info btn-xs">View</a>
          {{-- <button class="btn btn-xs {{ ($row->status==1) ? 'btn-success' : 'btn-danger' }}" onclick="updateStatus({{ $row->id }})" {{ (Auth::id()==$row->id) ? 'disabled' : '' }}>{{ ($row->status==1) ? 'Active' : 'Inactive' }}</button>
          <form action="{{ route('teams.status') }}" method="post" id="form-status{{ $row->id }}" style="display: none;">
          @csrf
          @method('patch')
          <input type="hidden" name="id" value="{{ $row->id }}">
          <input type="hidden" name="status" value="{{ $row->status }}">
          <button class="btn btn-danger" type="submit">Status</button>
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
  <!-- Status-->
  @component('components.status-delete-js')
  @slot('form')
      form-status
  @endslot
  @slot('title')
      updateStatus
  @endslot
  @endcomponent
  <script>
    function setOrganization(ele,id) {
      var organization_id = $(ele).val();
      $.ajax({
        url: '{{ route('leads.org') }}',
        type: 'POST',
        dataType: 'json',
        data: {id: id, organization_id: organization_id, _token: '{{ csrf_token() }}'},
      })
      .done(function(data) {
        if(data.status=="success")
        {
          $.notify(data.msg,'success');
        }
      });
      
    }

    function setUser(ele,id) {
      var user_id = $(ele).val();
      $.ajax({
        url: '{{ route('leads.user') }}',
        type: 'POST',
        dataType: 'json',
        data: {id: id, user_id: user_id, _token: '{{ csrf_token() }}'},
      })
      .done(function(data) {
        if(data.status=="success")
        {
          $.notify(data.msg,'success');
        }
      });
      
    }
  </script>
@endsection