@extends('layouts.master')

@section('content')
<div class="content-wrapper">
  <div class="content-heading">
     <span><em class="fa fa-file-text-o"></em>  {{ $form->title }}</span> 
     <div class="pull-right"><a href="{{ route('forms.index') }}" class="btn btn-info btn-sm"><em class="fa fa-file-text-o"></em> Form list </a></div>
  </div>

  <div class="panel panel-default">
     <div class="panel-body">
       <form action="#">
         {!! $form->content !!}
       </form>
     </div>
  </div>
</div>
@endsection

@section('custom_js')

@endsection