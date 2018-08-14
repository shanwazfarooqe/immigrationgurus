@extends('layouts.master')

@section('content')
<div class="content-wrapper">
  <div class="content-heading">
   <span><i class="fa fa-group"></i> Organisation details</span> 
 </div>

 <div class="panel panel-default">
   <div class="panel-body" style="position: relative;">
    <a href="{{ route('organizations.edit',['id'=>base64_encode($organization->id)]) }}" class="edit_org"><i class="fa fa-edit fa-lg text-gray-dark"></i></a>
    <div class="text-center">
     <h3>{{ $organization->name }}</h3>
     <p style="margin-bottom: 3px;"><em class="fa fa-envelope fa-fw"></em> :  {{ $organization->email }}</p>
     @if($organization->phone)<p style="margin-bottom: 3px;"><em class="fa fa-phone fa-fw"></em> :  {{ $organization->phone }} </p>@endif
     @if($organization->website)<p style="margin-bottom: 3px;"><em class="fa fa-globe fa-fw"></em> :  <a href="{{ $organization->website }}" target="_blank">{{ $organization->website }}</a></p>@endif
   </div>
   <hr>
   <div class="row">
     <div class="col-sm-4 col-sm-offset-8">
      <input type="text" name="" class="form-control" placeholder="Search user..">
    </div>
  </div>
  <hr>

  <div class="row">
  @if(!empty($leads))
  @foreach ($leads as $row)
   <div class="col-sm-3">
    <!-- START widget-->
    <div class="panel widget">
     <div class="panel-body bg-purple text-center">
      <p>
       <img src="{{ (file_exists(asset($row->image))) ? asset($row->image) : asset('img/user/8.jpg') }}" alt="" class="img-rounded thumb80">
     </p>
     <p>
       <strong>{{ $row->first_name }} {{ $row->last_name }}</strong><br>
       <em class="fa fa-envelope fa-fw"></em> :  {{ $row->email }}<br>
       <em class="fa fa-phone fa-fw"></em> :  {{ $row->phone }}
     </p>
     <a href="{{ route('leads.show',['id'=>base64_encode($row->id)]) }}" class="btn btn-info btn-xs">View profile</a>
   </div>
 </div>
 <!-- END widget-->
</div>
@endforeach
@endif
@if(count($leads)===0)
  <div class="row">
    <div class="col-sm-12">
      <div class="panel widget">
       <div class="panel-body text-center">
        <p>No data to display</p>
       </div>
      </div>
    </div>
  </div>
@endif

</div>
<hr>

<div class="row">
  <div class="col-sm-12">
    <div class="pull-right">
      <a class="btn btn-primary btn-sm" href="{{ route('leads.index') }}">View all</a>
    </div>
  </div>
</div>
</div>
</div>

<div class="row">{{-- 
  <div class="col-sm-12">
    <div class="panel panel-default">
     <div class="panel-body">
      <div class="row" style="padding-bottom: 15px;">
        <div class="col-sm-12">
          <a href="start-communication.html" class="btn btn-sm btn-info pull-right">New email</a>
        </div>
      </div>

      <div class="table-responsive">
       <table class="table table-striped table-hover">
         <thead>
           <tr>
             <th>Date - Time </th>
             <th>Topic</th>
             <th>Posted by</th>
           </tr>
         </thead>
         <tbody id="myTable">
          <tr>
           <td>21-10-18 2:30 pm</td>
           <td><a href="view-topic3.html">Request for more information</a></td>
           <td>John  </td>
         </tr>
         <tr>
           <td>10-05-18 9:30 am</td>
           <td><a href="view-topic3.html">Scanned passport copy required</a></td>
           <td>Jack</td>
         </tr>
       </tbody>
     </table>
   </div>
 </div>
</div>
</div>
 --}}</div>
                
</div>
@endsection

@section('custom_js')
@endsection