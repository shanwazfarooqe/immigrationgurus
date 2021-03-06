@extends('layouts.master')

@section('content')
<div class="content-wrapper">
  <div class="content-heading">
     <span><em class="fa fa-file-text-o"></em>  {{ $category->name }}</span> 
     <div class="pull-right"><a href="{{ route('forms.index') }}" class="btn btn-info btn-sm"><em class="fa fa-file-text-o"></em> Form list </a></div>
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

            <form id="form{{ $loop->index }}" method="post" style="padding-top: 30px;">
              {!! $row->content !!}
              <div class="form-group">
                @if(!$loop->first) <button type="button" onclick="formPrev({{ $loop->index }},{{ $loop->index-1 }})" class="btn btn-info">Prev</button> @endif
                @if($loop->last) 
                <button type="button" onclick="formSubmit({{ $row->id }}, {{ $loop->index }})" class="btn btn-info">Submit</button>
                @else
                  <button type="button" onclick="formNext({{ $row->id }}, {{ $loop->index }}, {{ $loop->iteration }})" class="btn btn-info">Next</button>
                @endif
              </div>
            </form>

        </div>
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
      var form = $('#form'+index).inputValues();
      var storArray = JSON.stringify( form );
      localStorage.setItem('form'+id, storArray);
      $('a[href="#tabform'+next+'"]').click();
    }
    function formPrev(index,prev) {
      $('a[href="#tabform'+prev+'"]').click();
    }
    function formSubmit(id,index) {
      var form = $('#form'+index).inputValues();
      var storArray = JSON.stringify( form );
      localStorage.setItem('form'+id, storArray);
      var fd = new FormData();
      fd.append( '_token', '{{ csrf_token() }}' );

      $('input[name="file[]"]').each(function(index, el) {
        fd.append("file[]", el.files[0]);
      });

      fd.append('category_id', {{ $category->id }});

      @foreach ($category->forms as $row)
        fd.append('form_id[]', {{ $row->id }});
        fd.append('form_data[]', localStorage.getItem('form{{ $row->id }}'));
      @endforeach
      $.ajax({
        url: '{{ route('leads.formdata') }}',
        data: fd,
        processData: false,
        contentType: false,
        type: 'POST',
        dataType: 'json',
        success: function(data){
          localStorage.clear();
          $.notify(data.msg,'success');
          location.href="{{ route('leads.application',['id'=>base64_encode($id)]) }}";
        }
      });
    }
  </script>

@endsection