@extends('layouts.master')

@section('content')
<div class="content-wrapper">
  <div class="content-heading">
     <span><em class="fa fa-file-text-o"></em>  {{ $category->name }}</span> 
     <div class="pull-right"><a href="{{ route('forms.index') }}" class="btn btn-info btn-sm"><em class="fa fa-file-text-o"></em> Form list </a></div>
  </div>

  <div class="panel panel-default">
     <div class="panel-body">
       <form action="{{ route('forms.customer') }}" class="form-horizontal" method="post">
        @csrf
        <input type="hidden" name="category_id" value="{{ $category->id }}">
         <div class="form-group">
           <div class="col-sm-12">
             <label class="control-label">Select customers</label>
             <select name="customer_id[]" class="form-control select2-4" multiple="" required="">
               <option value="">Select</option>
               @if(count($leads)!==0)
               @foreach ($leads as $row)

                 <option value="{{ $row->id }}" @if($category->lead_id) {{ (in_array($row->id, json_decode($category->lead_id))) ? 'selected' : '' }} @endif>{{ $row->first_name }} {{ $row->last_name }}</option>
                 
               @endforeach
               @endif
             </select>
           </div>
         </div>
         <div class="form-group">
           <div class="col-sm-12">
             <button type="submit" class="btn btn-info pull-right">Submit</button>
           </div>
         </div>
       </form>
     </div>
  </div>
</div>
@endsection

@section('custom_css')
  <style>
    .form-group {
      padding: 0 15px;
    }
  </style>
  <link rel="stylesheet" href="{{ asset('css/select2-bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('css/select2.css') }}">
@endsection

@section('custom_js')
  <script src="{{ asset('js/select2.js') }}"></script>
@endsection