@extends('layouts.master')

@section('content')
<div class="content-wrapper">
  <div class="content-heading">
     <span><em class="fa fa-file-text-o"></em>  {{ $category->name }}</span> 
     <div class="pull-right"><a href="{{ route('leads.application',['lead'=>base64_encode($lead)]) }}" class="btn btn-info btn-sm"><em class="fa fa-file-text-o"></em> Form Data View </a></div>
  </div>

  <div class="panel panel-default">
     <div class="panel-body">
      <ul class="nav nav-tabs">
      @foreach ($category->forms as $row)
        <li @if($loop->first) class="active" @endif><a data-toggle="tab" href="#tabform{{ $loop->index }}">{{ $row->title }}</a></li>
      @endforeach
      </ul>

      <div class="tab-content">
        @foreach ($category->forms as $row)
        <div id="tabform{{ $loop->index }}" class="tab-pane fade @if($loop->first)  in active @endif">

            <form id="form{{ $row->id }}" method="post" style="padding-top: 30px;">
              {!! $row->content !!}
              <div class="form-group">
                @if(!$loop->first) <button type="button" onclick="formPrev({{ $loop->index }},{{ $loop->index-1 }})" class="btn btn-info">Prev</button> @endif
                @if($loop->last) 
                <a href="{{ route('leads.view',['lead'=>base64_encode($lead),'form'=>base64_encode($category->id)]) }}" class="btn btn-info">Finish</a>
                @else
                  <button type="button" onclick="formNext({{ $row->id }}, {{ $loop->index }}, {{ $loop->iteration }})" class="btn btn-info">Next</button>
                @endif
              </div>
            </form>

        </div>
        @endforeach
      </div>

      <div class="row">
      @foreach($formfiles as $row2)
      @foreach(json_decode($row2->files) as $row)
        <div class="col-sm-2">
          <div class="file-icon-c2 text-center">  
                 
            <div class="boxdus">
              <i class="fa fa-file-text-o"></i>
              @php
                $fileArr = explode('/', $row);
              @endphp
              <p>{{ $fileArr[count($fileArr)-1] }} <br><span></span></p>
            </div>
            <div class="row rowcmc">
            <div class="col-sm-12 footerlist-attach">
              <a href="{{ asset($row) }}" title="Download">
                <i class="fa fa-cloud-download"></i></a>
              {{-- <a href="{{ asset($row) }}" title="Delete" id="swal-demo5"><i class="fa fa-trash"></i></a> --}}
              <a href="{{ asset($row) }}" title="View" target="_blank"><i class="fa fa-search-plus"></i></a>
           
          </div>
          </div>
          </div>
        </div>
      @endforeach
      @endforeach
      </div>

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
@endsection

@section('custom_js')
  <script src="{{ asset('js/input-values.jquery.js') }}"></script>
  <script src="{{ asset('js/bootstrap-filestyle.js') }}"></script>
  <script>
    function formNext(id,index,next) {
      $('a[href="#tabform'+next+'"]').click();
    }
    function formPrev(index,prev) {
      $('a[href="#tabform'+prev+'"]').click();
    }

    @foreach($formdatas as $row)
      var obj = {!! $row->content !!};

      for (var key in obj) {
        if (obj.hasOwnProperty(key)) {
          $('#form{{ $row->form_id }}').inputValues(key, obj[key]);
        }
      }
    @endforeach
  </script>

@endsection