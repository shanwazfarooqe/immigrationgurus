@extends('layouts.master')

@section('content')
<div class="content-wrapper">
  <div class="content-heading">
   <span><em class="fa fa-file-text-o"></em>  Create form </span> 
   <div class="pull-right"> <button style="cursor: pointer;display: none" class="btn btn-info export_html mt-2 pull-right" data-toggle="modal" data-target="#myModal2">Create form</button></div>
 </div>
 <div class="panel panel-default" style="height: auto;overflow: -webkit-paged-x;">

   <div class="panel-body">


     <div class="form_builder" style="margin-top: 25px">
      <div class="row">
        <div class="col-sm-3">
          <nav class="nav-sidebar">
            <ul class="nav">
              <li  title="Drag and drop me to draw Text Field " class="form_bal_textfield">
                <a href="javascript:;">Text Field <i class="fa fa-plus-circle pull-right"></i></a>
              </li>
              <li  title="Drag and drop me to draw Text Area" class="form_bal_textarea">
                <a href="javascript:;">Text Area <i class="fa fa-plus-circle pull-right"></i></a>
              </li>
              <li  title="Drag and drop me to draw Select Box" class="form_bal_select">
                <a href="javascript:;">Select <i class="fa fa-plus-circle pull-right"></i></a>
              </li>
              <li  title="Drag and drop me to draw Radio Button" class="form_bal_radio">
                <a href="javascript:;">Radio Button <i class="fa fa-plus-circle pull-right"></i></a>
              </li>
              <li  title="Drag and drop me to draw Checkbox" class="form_bal_checkbox">
                <a href="javascript:;">Checkbox <i class="fa fa-plus-circle pull-right"></i></a>
              </li>
              <li  title="Drag and drop me to draw Email" class="form_bal_email">
                <a href="javascript:;">Email <i class="fa fa-plus-circle pull-right"></i></a>
              </li>
              <li  title="Drag and drop me to draw Number" class="form_bal_number">
                <a href="javascript:;">Number <i class="fa fa-plus-circle pull-right"></i></a>
              </li>
              <li  title="Drag and drop me to draw Password" class="form_bal_password">
                <a href="javascript:;">Password <i class="fa fa-plus-circle pull-right"></i></a>
              </li>
              <li  title="Drag and drop me to draw Date" class="form_bal_date">
                <a href="javascript:;">Date <i class="fa fa-plus-circle pull-right"></i></a>
              </li>
              <li  title="Drag and drop me to draw Button" class="form_bal_button">
                <a href="javascript:;">Button <i class="fa fa-plus-circle pull-right"></i></a>
              </li>
            </ul>
          </nav>
        </div>
        <div class="col-sm-4  bal_builder">
          <div class="form_builder_area"></div>
        </div>
        <div class="col-sm-4 col-sm-offset-1">
          <div class="col-sm-12">
              <div class="preview"></div>
              <div style="display: none" class="form-group plain_html"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
@endsection

@section('custom_css')
<link rel="stylesheet" href="{{ asset('css/form_builder.css') }}"/>
@endsection

@section('custom_js')
  <!-- Modal -->
  <div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog modal-sm">

      <!-- Modal content-->
      <div class="modal-content" >
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Save form</h4>
        </div>
        <form class="form-horizontal" id="form-html" method="post" action="{{ route('forms.store') }}">
        @csrf
        <div class="modal-body">
           <div class="form-group">
            <div class="col-sm-12">
             <label class="control-label">Form name</label>
             <input type="text" name="title" class="form-control">
             <textarea id="contenthtml" name="content" rows="50" class="form-control hide"></textarea>
             <textarea id="orghtml" name="org_content" rows="50" class="form-control hide"></textarea>
           </div>
         </div>
     </div>
     <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
      <button type="submit" class="btn btn-success" >Save</button>
    </div>
    </form>
  </div>

  </div>
  </div>

  <!-- drag and drop -->
  <script src="{{ asset('js/popper.min.js') }}"></script>
  <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
  <script src="{{ asset('js/form_builder.js') }}"></script>
  <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-36251023-1']);
    _gaq.push(['_setDomainName', 'jqueryscript.net']);
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

  </script>
  @component('components.form-submit')
      @slot('form')
          form-html
      @endslot

      @slot('redirect')
        {{ route('forms.index') }}
      @endslot
  @endcomponent
@endsection