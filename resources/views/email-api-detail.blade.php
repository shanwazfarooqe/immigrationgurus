@extends('layouts.master')

@section('content')
@if(LaravelGmail::check())
<section>
 <div class="content-wrapper">
   
     <div class="content-heading">
      <span><i class="fa fa-commenting-o"></i> {{ $filtered->load()->getSubject() }}</span> 
    </div>

    <div class="panel panel-default">
      <div class="panel-body">

       <div class="row msg_row">
         <div class="col-sm-12">
          <div class="user_mg_row">
            <div class="user_mg_col">
              <div class="name_circle">{{ substr( $filtered->getFromName(), 0, 1 ) }}</div>
            </div>
            <div class="user_mg_col">
              <h5>{{ $filtered->getFromName() }} <small>< {{ $filtered->getFromEmail() }} ></small>
             
              <div class="dropdown">
                 <a class="dropdown-toggle mail-dropd" type="button" id="menu1" data-toggle="dropdown">{{ $filtered->getFromName() }}
                 <span class="caret"></span></a>
                 <ul class="dropdown-menu maildrp" role="menu" aria-labelledby="menu1">
                 <li role="presentation">
                   <div class="mail-drop-row">
                     <div class="mail-drop-col1">  from :</div>
                      <div class="mail-drop-col2"> {{ $filtered->getFromName() }} < {{ $filtered->getFromEmail() }} ></div>
                   </div>
                </li>
                <li role="presentation">
                   <div class="mail-drop-row">
                     <div class="mail-drop-col1">  To :</div>
                      <div class="mail-drop-col2">   {{ LaravelGmail::user() }} </div>
                   </div>
                </li>
                <li role="presentation">
                   <div class="mail-drop-row">
                     <div class="mail-drop-col1">  date :</div>
                      <div class="mail-drop-col2"> {{ date('d/m/Y',strtotime($filtered->getDate())) }}</div>
                   </div>
                </li>
                <li role="presentation">
                   <div class="mail-drop-row">
                     <div class="mail-drop-col1">  subject :</div>
                      <div class="mail-drop-col2"> {{ $filtered->load()->getSubject() }}</div>
                   </div>
                </li>
                <li role="presentation">
                   <div class="mail-drop-row">
                     <div class="mail-drop-col1">  mailed-by :</div>
                      <div class="mail-drop-col2"> {{ $filtered->getFromEmail() }}</div>
                   </div>
                </li>
                 </ul>
               </div>
              </h5>

             
              
            </div>
            <div class="mail-right-op">
              <a href="javascript:void(0)"><small>{{ date('d/m/Y',strtotime($filtered->getDate())) }} ({{ $filtered->getDate()->diffForHumans() }})</small></a>
               <a href="javascript:void(0)" title="Reply" data-toggle="tooltip" class="replybtn"><i class="fa fa-mail-reply"></i></a>
            </div>
          </div>
            <div class="mail-para">
              {!! $filtered->load()->getHtmlBody() !!}
            </div>
          @if($filtered->hasAttachments())
          
          <!-- attachment row -->
          <div class="row">
          @foreach($filtered->load()->getAttachments() as $att)
           <div class="col-sm-2">
             <div class="file-icon-c2 text-center">  
               
               <div class="boxdus">
                 <i class="fa fa-file-text-o"></i>
                 <p>{{ $att->getFileName() }}<br><span>{{-- (001 KB) --}}</span></p>
               </div>
               @php
                 $data = strtr($att->getData(), array('-' => '+', '_' => '/'));
                  $myfile = fopen($att->getFileName(), "w+");;
                  fwrite($myfile, base64_decode($data));
                  fclose($myfile);
               @endphp
               <div class="row rowcmc">
                 <div class="col-sm-12 footerlist-attach">
                   <a href="{{ asset($att->getFileName()) }}" title="Download" download>
                     <i class="fa fa-cloud-download"></i></a>
                     {{-- <a href="{{ asset($att->getFileName()) }}" title="Delete" id="swal-demo5"><i class="fa fa-trash"></i></a> --}}
                     <a href="{{ asset($att->getFileName()) }}" download title="View"><i class="fa fa-search-plus"></i></a>
                     
                   </div>
                 </div>
               </div>
             </div>
             @endforeach
             </div>
             <!-- attachment row end -->
             @endif
           </div>
         </div>

         <div class="row">
           <div class="col-sm-12">
               <button class="btn btn-default replybtn" type="button">Reply <i class="fa fa-mail-reply"></i></button>
               <hr>
           </div>
         </div>



           <div class="panel-body reply-panel">
             <form class="form-horizontal">
               <div class="card-body">

                 <div class="form-group mb row">

                  <div class="col-sm-12">
                    <label class="control-label"></label>
                    <div data-role="editor-toolbar" data-target="#editor" class="btn-toolbar btn-editor">
                      <div class="btn-group">
                       <a data-edit="bold" data-toggle="tooltip" title="Bold (Ctrl/Cmd+B)" class="btn btn-default btnwysing">
                        <i class="fa fa-bold"></i>
                      </a>
                      <a data-edit="italic" data-toggle="tooltip" title="Italic (Ctrl/Cmd+I)" class="btn btn-default btnwysing">
                        <i class="fa fa-italic"></i>
                      </a>
                      <a data-edit="strikethrough" data-toggle="tooltip" title="Strikethrough" class="btn btn-default btnwysing">
                        <i class="fa fa-strikethrough"></i>
                      </a>
                      <a data-edit="underline" data-toggle="tooltip" title="Underline (Ctrl/Cmd+U)" class="btn btn-default btnwysing">
                        <i class="fa fa-underline"></i>
                      </a>
                    </div>
                    <div class="btn-group">
                     <a data-edit="insertunorderedlist" data-toggle="tooltip" title="Bullet list" class="btn btn-default btnwysing">
                      <i class="fa fa-list-ul"></i>
                    </a>
                    <a data-edit="insertorderedlist" data-toggle="tooltip" title="Number list" class="btn btn-default btnwysing">
                      <i class="fa fa-list-ol"></i>
                    </a>
                    <a data-edit="outdent" data-toggle="tooltip" title="Reduce indent (Shift+Tab)" class="btn btn-default btnwysing">
                      <i class="fa fa-dedent"></i>
                    </a>
                    <a data-edit="indent" data-toggle="tooltip" title="Indent (Tab)" class="btn btn-default btnwysing">
                      <i class="fa fa-indent"></i>
                    </a>
                  </div>
                  <div class="btn-group">
                   <a data-edit="justifyleft" data-toggle="tooltip" title="Align Left (Ctrl/Cmd+L)" class="btn btn-default btnwysing">
                    <i class="fa fa-align-left"></i>
                  </a>
                  <a data-edit="justifycenter" data-toggle="tooltip" title="Center (Ctrl/Cmd+E)" class="btn btn-default btnwysing">
                    <i class="fa fa-align-center"></i>
                  </a>
                  <a data-edit="justifyright" data-toggle="tooltip" title="Align Right (Ctrl/Cmd+R)" class="btn btn-default btnwysing">
                    <i class="fa fa-align-right"></i>
                  </a>
                  <a data-edit="justifyfull" data-toggle="tooltip" title="Justify (Ctrl/Cmd+J)" class="btn btn-default btnwysing">
                    <i class="fa fa-align-justify"></i>
                  </a>
                </div>
                <div class="btn-group dropdown">
                 <a data-toggle="dropdown" title="Hyperlink" class="btn btn-default btnwysing">
                  <i class="fa fa-link"></i>
                </a>
                <div class="dropdown-menu">
                  <div class="input-group ml-xs mr-xs">
                   <input id="LinkInput" placeholder="URL" type="text" data-edit="createLink" class="form-control input-sm">
                   <div class="input-group-btn">
                    <button type="button" class="btn btn-sm btn-default btnwysing">Add</button>
                  </div>
                </div>
              </div>
              <a data-edit="unlink" data-toggle="tooltip" title="Remove Hyperlink" class="btn btn-default btnwysing">
                <i class="fa fa-cut"></i>
              </a>
            </div>
            <div class="btn-group">
             <a id="pictureBtn" data-toggle="tooltip" title="Insert picture (or just drag &amp; drop)" class="btn btn-default btnwysing">
              <i class="fa fa-picture-o"></i>
            </a>
            <input type="file" data-edit="insertImage" style="position:absolute; opacity:0; width:41px; height:34px">
          </div>
          <div class="btn-group pull-right">
           <a data-edit="undo" data-toggle="tooltip" title="Undo (Ctrl/Cmd+Z)" class="btn btn-default btnwysing">
            <i class="fa fa-undo"></i>
          </a>
          <a data-edit="redo" data-toggle="tooltip" title="Redo (Ctrl/Cmd+Y)" class="btn btn-default btnwysing">
            <i class="fa fa-repeat"></i>
          </a>

        </div>
      </div>
      <div contenteditable="true" placeholder="Enter text here..." style="overflow:scroll; height:250px;max-height:250px" class="form-control wysiwyg mt-lg"></div>
    </div>
   </div>


   </div>


    <div class="form-group">
    <div class="col-sm-1">
      <a href="application.html" class="btn btn-warning ">Back</a>
    </div>
     <div class="col-sm-11">
        <label for="fileToUpload" style=" cursor:pointer;" class=" btn btn-purple btn-xs pull-right">
          <em class="icon-paper-clip" style=" font-size:20px;" title="Attach" data-toggle="tooltip"></em>
        </label>
        <input type="file" id="fileToUpload" multiple="" name="fileToUpload" class="hide" />
      <button class="btn btn-info " type="submit">Send <i class="fa fa-paper-plane"></i>
   </button>
     </div>  
   </div>
   </form>
   </div>

   </div>
   </div>



 </div>
</section>
@endif
@endsection

@section('custom_js')


  <!-- WYSIWYG for word editor-->
   <script src="{{ asset('js/bootstrap-wysiwyg/bootstrap-wysiwyg.js') }}"></script>
   <script src="{{ asset('js/bootstrap-wysiwyg/external/jquery.hotkeys.js') }}"></script>
   <script type="text/javascript">
     // WYSIWYG
    // ----------------------------------- 
   $('.wysiwyg').wysiwyg(); 
   </script>
  <script type="text/javascript">
    $(document).ready(function() {
    $(".replybtn").click(function(event) {
      $('.reply-panel').show();
       $('html, body').animate({
          scrollTop: $(".reply-panel").offset().top
        }, 1500);

    });  
    });
  </script>

@endsection