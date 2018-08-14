@extends('layouts.master')

@section('content')
<div class="content-wrapper">
  <div class="panel panel-default">
   <div class="panel-body">

    <div class="container-fluid">
     <div class="row">
      <div class="col-sm-12">
        <form action="{{ route('templates.mailupdate') }}" method="POST" role="form" class="form-horizontal" id="mail-form">
        @csrf
        <input type="hidden" name="template_id" value="{{ $template->id }}">
          <div class="">
           <div  class="card-header">
            <div class="row">
              <div class="col-sm-7">
               <h4><i class="fa fa-object-group"></i> Edit Templates</h4>
             </div>
             <div class="col-sm-2">
              <div class="">
               <div class="dropdown">
                <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">Attachments <span id="fileNum" class="text-warning"><strong>0</strong></span>
                </button>
                <ul class="dropdown-menu dropdown-menucm custdrop">

                  <li>
                    <div class="row" style="margin-left: 0px;"> 
                      <div class="col-xs-2"><i class="fa fa-plus add_attach"></i></div>
                      <div class="col-xs-10">
                        <label for="attach" class="attach">Add attachments</label>
                        <input type="file" onchange="updateSize2();"
                        id="attach" multiple="" />
                      </div>
                    </div>
                  </li>
                  <span class="attachHead"><!-- Attachmets will be show here--></span>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="pull-right">
             <button class="btn btn-default " type="reset">
             Cancel</button>
             <button class="btn btn-info " data-toggle="modal" data-target="#myModal-preview" type="button">Preview</button>

             <button class="btn btn-info " type="button" onclick="submitTemplate()">Save</button>
           </div>
         </div> 
       </div>
     </div>
     <hr>

     <div  class="card-header">
      <div class=" text-center">
        <h4>{{ $template->name }}</h4>
        <p>{{ $template->subject }}</p>
      </div>

    </div>
    <hr>

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

                                <!--  <a  data-toggle="tooltip" title="Attach File" class="btn btn-default btnwysing">
                                <label for="uploadInput" style=" cursor:pointer;margin: 0px;" >
                                 <i class="icon-paper-clip"></i>
                                </label>
                              <input type="file"  id="uploadInput" name="myFiles" onchange="updateSize();" multiple style="display:none;">
                                  
                            </a> -->
                            
                          </div>
                        </div>
                        <div contenteditable="true" placeholder="Enter text here..." style="overflow:scroll; height:250px;max-height:250px" class="form-control wysiwyg mt-lg" id="wysiwygeditor">{!! $template->mailTemplate->content !!}</div>
                      </div>
                    </div>


                  </div>

                </div>
                <textarea name="attachments" id="files" cols="30" rows="10" class="hide">{{ $template->mailTemplate->files }}</textarea>
                <textarea name="content" id="wysiwygtext" cols="30" rows="10" class="hide">{!! $template->mailTemplate->content !!}</textarea>
                <textarea name="to" id="totext" cols="30" rows="10" class="hide">{{ $template->mailTemplate->to }}</textarea>
                <textarea name="cc" id="cctext" cols="30" rows="10" class="hide">{{ $template->mailTemplate->cc }}</textarea>
                <textarea name="bcc" id="bcctext" cols="30" rows="10" class="hide">{{ $template->mailTemplate->bcc }}</textarea>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
@endsection

@section('custom_css')
<style type="text/css">
   .table thead th {
       font-weight: 600;
       background-color: #eeefee;
       color: #212b31;
       vertical-align: bottom;
       border-bottom: 2px solid #c2cfd6;
     }
     .mb-mails td {
       vertical-align: middle;
       border-bottom: 1px solid #e4eaec;
   }
   .mb-mails > tbody > tr > td {
       border-top-color: transparent;
       cursor: pointer;
   }
   .checkbox-star input[type=checkbox] {
       display: none;
   }
   .checkbox-star em {
       font-size: 24px;
   }
   .checkbox-star input[type="checkbox"]:checked+label {
       color: #FFBD0B;
   }
   .checkbox-star label {
     cursor: pointer;
     color: #9fb4bd;
 }
 </style>
@endsection

@section('custom_js')
<!-- Modal for preview-->
<div class="modal fade" id="myModal-preview" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> <i class="fa fa-envelope-open"></i> {{ $template->name }}</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <div class="modal-body">
       <div class="form-group row mrow2 feildup">

        <div class="input-group m-b ">
         <input type="text" class="form-control " placeholder="To :" style="border: none;" id="to-input" value="{{ $template->mailTemplate->to }}">
         <span class="input-group-addon add_cc" style="background-color:transparent;border: none; cursor: pointer;">Cc</span>
         <span class="input-group-addon add_bcc" style="background-color:transparent;border: none; cursor: pointer;">Bcc</span>
       </div>
     </div>
     <div class="form-group row mrow2" id="cctoggle" @if(!$template->mailTemplate->cc) style="display: none" @endif> <input type="text" class="form-control " placeholder="Cc :" style="border: none;" id="cc-input" value="{{ $template->mailTemplate->cc }}"></div>
     <div class="form-group row mrow2" id="bcctoggle" @if(!$template->mailTemplate->bcc) style="display: none" @endif> <input type="text" class="form-control " placeholder="Bcc :" style="border: none;" id="bcc-input" value="{{ $template->mailTemplate->bcc }}"></div>
     <div class="form-group row mrow">
       <strong> Subject: </strong>  {{ $template->subject }}
     </div>
     <div class="form-group row mrow">

       <strong> Attachments: </strong>
       <span id="att-arr"></span>
       {{-- <a href="">David Thalhofer Resume.pdf 41.0 MB</a>
       <i class="fa fa-minus"></i>
       <a href="">David Thalhofer Resume.pdf 41.0 MB</a>  --}}
     </div>

     <div class="form-group row mrow" style="border: none;">
      <p> Dear ${Name},</p>
      <p id="wysiwygprv">
      </p>
      <p>
        <strong>Regards</strong><br>
        ${userSignature}
      </p>

    </div>

  </div>
</div>
</div>
</div>

<!-- WYSIWYG for word editor-->
 <script src="{{ asset('js/bootstrap-wysiwyg/bootstrap-wysiwyg.js') }}"></script>
 <script src="{{ asset('js/bootstrap-wysiwyg/external/jquery.hotkeys.js') }}"></script>
 <script type="text/javascript">
   // WYSIWYG
  // ----------------------------------- 
 $('.wysiwyg').wysiwyg(); 
 </script>

<!-- hide and show -->
<script>
 
       $(document).ready(function(){
        $("#data-permission").hide();
        $("#usercu").hide();
        $("#followcu").hide();
        $("#Following-Users").click(function(){
        $("#data-permission").show();
        $("#followcu").show();
        $("#usercu").hide();
        $("#groupcu").hide();
        });
       $("#All-Users").click(function(){
        $("#data-permission").hide();
        $("#groupcu").show();
         $("#followcu").hide();
          $("#usercu").hide();
        });
        $("#Only-with-me").click(function(){
        $("#data-permission").hide();
        $("#usercu").show();
        $("#groupcu").hide();
       $("#followcu").hide();
        });

       
     /* hide the file list when click ouside*/
        $( "body" ).click(function( event ) {
            var target = $( event.target );
            //if ( target.is( ".closss" ) ) {
            if ( target.hasClass('thishide')) {
            $(".custdrop").addClass('open');
            }
            else
            {
               $(".custdrop").removeClass('open');
            }
          });

        $(".add_cc").click(function(event) {
         $("#cctoggle").toggle();
        });

        $(".add_bcc").click(function(event) {
         $("#bcctoggle").toggle();
        });

       });
</script>
 
<script>

  $(document).ready(function() {
     var oFiles = JSON.parse('{!! $template->mailTemplate->files !!}');
     var nFiles = oFiles.length;
     var innerval= $("#fileNum").html();
     if(innerval=='<strong>0</strong>')
     {
      innerval = 0;
     }
     if (nFiles==0)
     {
        $("#fileNum").html(innerval);
     }
      else
     {
        $("#fileNum").html(parseInt(innerval)+nFiles);
     }

  // for (var i = 0; i < nFiles; i++)
  // {
    @if(!empty(json_decode($template->mailTemplate->files)))
    @foreach(json_decode($template->mailTemplate->files) as $element)
    var i = {{ $loop->index }};
    var fileNames= oFiles[i];
    var ExtenTn= fileNames.split('.').pop();
    @if(file_exists( storage_path('app\public\attachements\\'.$template->id.'\\'.$element) ))
    var fileSiz = {{ filesize(storage_path('app\public\attachements\\'.$template->id.'\\'.$element)) }};
    @else {
      var fileSiz = 0;
    }
    @endif
    
    //fileSiz= get_filesize();
    var OrgSiz=fileSiz/1024;
    if (ExtenTn== "docx") {
    $(".attachHead").after('<li> <div class="row" style="margin-left: 0px;"> <div class="col-xs-2"><em class="fa fa-file-word-o" style="font-size:25px;color:#94a6ad" id="addicon"></em></div><div class="col-xs-8"><p class="filenames">'+ fileNames+ '</p><small>'+ OrgSiz +' KB</small></div><div class="col-xs-2"><a href="javascript:void(0)" onclick="deleteFile(this,\''+ fileNames+ '\')" class="closss"><i class="fa fa-close thishide"></i></a></div></div></li>');
     }

      else if (ExtenTn== "pdf") {
   
    $(".attachHead").append('<li> <div class="row" style="margin-left: 0px;"> <div class="col-xs-2"><em class="fa fa-file-pdf-o" style="font-size:25px;color:#da2222" id="addicon"></em></div><div class="col-xs-8"><p class="filenames">'+ fileNames+ '</p><small>'+ OrgSiz +' KB</small></div><div class="col-xs-2"><a href="javascript:void(0)" onclick="deleteFile(this,\''+ fileNames+ '\')" class="closss"><i class="fa fa-close thishide"></i></a></div></div></li>');
     }
      else if (ExtenTn== "xlsx") {
   
    $(".attachHead").append('<li> <div class="row" style="margin-left: 0px;"> <div class="col-xs-2"><em class="fa fa-file-excel-o" style="font-size:25px;color:#19923e" id="addicon"></em></div><div class="col-xs-8"><p class="filenames">'+ fileNames+ '</p><small>'+ OrgSiz +' KB</small></div><div class="col-xs-2"><a href="javascript:void(0)" onclick="deleteFile(this,\''+ fileNames+ '\')" class="closss"><i class="fa fa-close thishide"></i></a></div></div></li>');
     }
      else if (ExtenTn== "zip") {
   
    $(".attachHead").append('<li> <div class="row" style="margin-left: 0px;"> <div class="col-xs-2"><em class="fa fa-file-zip-o" style="font-size:25px;color:#580063" id="addicon"></em></div><div class="col-xs-8"><p class="filenames">'+ fileNames+ '</p><small>'+ OrgSiz +' KB</small></div><div class="col-xs-2"><a href="javascript:void(0)" onclick="deleteFile(this,\''+ fileNames+ '\')" class="closss"><i class="fa fa-close thishide"></i></a></div></div></li>');
     }
     else if (ExtenTn== "jpg" || ExtenTn== "png") {
   
    $(".attachHead").append('<li> <div class="row" style="margin-left: 0px;"> <div class="col-xs-2"><em class="fa fa-file-photo-o" style="font-size:25px;color:#e48f0f" id="addicon"></em></div><div class="col-xs-8"><p class="filenames">'+ fileNames+ '</p><small>'+ OrgSiz +' KB</small></div><div class="col-xs-2"><a href="javascript:void(0)" onclick="deleteFile(this,\''+ fileNames+ '\')" class="closss"><i class="fa fa-close thishide"></i></a></div></div></li>');
     }
  
     else
     {
       $(".attachHead").append('<li> <div class="row" style="margin-left: 0px;"> <div class="col-xs-2"><em class="fa fa-sticky-note" style="font-size:25px;color:#DEDBDB" id="addicon"></em></div><div class="col-xs-8"><p class="filenames">'+ fileNames+ '</p><small>'+ OrgSiz +' KB</small></div><div class="col-xs-2"><a href="javascript:void(0)" onclick="deleteFile(this,\''+ fileNames+ '\')" class="closss"><i class="fa fa-close thishide"></i></a></div></div></li>');
     }
  @endforeach
  @endif
  });


 /*number of files choosen  and preview attachments  ==================================*/
function updateSize2() {

   var oFiles = document.getElementById("attach").files;
   var nFiles = oFiles.length;
   var innerval= $("#fileNum").html();
   if(innerval=='<strong>0</strong>')
   {
    innerval = 0;
   }
   if (nFiles==0) {
    $("#fileNum").html(innerval);
    }
    else
    {
    $("#fileNum").html(parseInt(innerval)+nFiles);
    var data = new FormData();
    $.each(oFiles, function(i, file) {
        data.append('file[]', file);
    });
    data.append( '_token', '{{ csrf_token() }}' );
    data.append( 'template_id', {{ $template->id }} );
    $.ajax({
      url: '{{ route('templates.files') }}',
      type: 'POST',
      dataType: 'json',
      data: data,
      contentType: false,
      processData: false
    })
    .done(function(data) {
      if(data.status=="success")
      {
        var files  = $('#files').val();
        if(files)
        {
          files = JSON.parse(files);
          files.push(data.files[0]);
          var uniqueNames = [];
          $.each(files, function(i, el){
              if($.inArray(el, uniqueNames) === -1) uniqueNames.push(el);
          });
        }
        else
        {
          var uniqueNames = data.files;
        }
        $('#files').val(JSON.stringify(uniqueNames));
        //$('#files').val(JSON.stringify(data.files));
      }
    });
    
   }
   for (var i = 0; i < nFiles; i++)
          {

            var fileNames= oFiles[i].name;
            var ExtenTn= fileNames.split('.').pop();
            var fileSiz= oFiles[i].size;
            var OrgSiz=fileSiz/1024;
            if (ExtenTn== "docx") {
            $(".attachHead").after('<li> <div class="row" style="margin-left: 0px;"> <div class="col-xs-2"><em class="fa fa-file-word-o" style="font-size:25px;color:#94a6ad" id="addicon"></em></div><div class="col-xs-8"><p class="filenames">'+ fileNames+ '</p><small>'+ OrgSiz +' KB</small></div><div class="col-xs-2"><a href="javascript:void(0)" onclick="deleteFile(this,\''+ fileNames+ '\')" class="closss"><i class="fa fa-close thishide"></i></a></div></div></li>');
             }

              else if (ExtenTn== "pdf") {
           
            $(".attachHead").append('<li> <div class="row" style="margin-left: 0px;"> <div class="col-xs-2"><em class="fa fa-file-pdf-o" style="font-size:25px;color:#da2222" id="addicon"></em></div><div class="col-xs-8"><p class="filenames">'+ fileNames+ '</p><small>'+ OrgSiz +' KB</small></div><div class="col-xs-2"><a href="javascript:void(0)" onclick="deleteFile(this,\''+ fileNames+ '\')" class="closss"><i class="fa fa-close thishide"></i></a></div></div></li>');
             }
              else if (ExtenTn== "xlsx") {
           
            $(".attachHead").append('<li> <div class="row" style="margin-left: 0px;"> <div class="col-xs-2"><em class="fa fa-file-excel-o" style="font-size:25px;color:#19923e" id="addicon"></em></div><div class="col-xs-8"><p class="filenames">'+ fileNames+ '</p><small>'+ OrgSiz +' KB</small></div><div class="col-xs-2"><a href="javascript:void(0)" onclick="deleteFile(this,\''+ fileNames+ '\')" class="closss"><i class="fa fa-close thishide"></i></a></div></div></li>');
             }
              else if (ExtenTn== "zip") {
           
            $(".attachHead").append('<li> <div class="row" style="margin-left: 0px;"> <div class="col-xs-2"><em class="fa fa-file-zip-o" style="font-size:25px;color:#580063" id="addicon"></em></div><div class="col-xs-8"><p class="filenames">'+ fileNames+ '</p><small>'+ OrgSiz +' KB</small></div><div class="col-xs-2"><a href="javascript:void(0)" onclick="deleteFile(this,\''+ fileNames+ '\')" class="closss"><i class="fa fa-close thishide"></i></a></div></div></li>');
             }
             else if (ExtenTn== "jpg" || ExtenTn== "png") {
           
            $(".attachHead").append('<li> <div class="row" style="margin-left: 0px;"> <div class="col-xs-2"><em class="fa fa-file-photo-o" style="font-size:25px;color:#e48f0f" id="addicon"></em></div><div class="col-xs-8"><p class="filenames">'+ fileNames+ '</p><small>'+ OrgSiz +' KB</small></div><div class="col-xs-2"><a href="javascript:void(0)" onclick="deleteFile(this,\''+ fileNames+ '\')" class="closss"><i class="fa fa-close thishide"></i></a></div></div></li>');
             }
          
             else
             {
               $(".attachHead").append('<li> <div class="row" style="margin-left: 0px;"> <div class="col-xs-2"><em class="fa fa-sticky-note" style="font-size:25px;color:#DEDBDB" id="addicon"></em></div><div class="col-xs-8"><p class="filenames">'+ fileNames+ '</p><small>'+ OrgSiz +' KB</small></div><div class="col-xs-2"><a href="javascript:void(0)" onclick="deleteFile(this,\''+ fileNames+ '\')" class="closss"><i class="fa fa-close thishide"></i></a></div></div></li>');
             }
  }

}



// move data from left to right ==========================================
(function () {
    $('#btnRight').click(function (e) {
        var selectedOpts = $('#lstBox1 option:selected');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }

        $('#lstBox2').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });

    $('#btnAllRight').click(function (e) {
        var selectedOpts = $('#lstBox1 option');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }

        $('#lstBox2').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });

    $('#btnLeft').click(function (e) {
        var selectedOpts = $('#lstBox2 option:selected');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }

        $('#lstBox1').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });

    $('#btnAllLeft').click(function (e) {
        var selectedOpts = $('#lstBox2 option');
        if (selectedOpts.length == 0) {
            alert("Nothing to move.");
            e.preventDefault();
        }

        $('#lstBox1').append($(selectedOpts).clone());
        $(selectedOpts).remove();
        e.preventDefault();
    });
}(jQuery));

// delete the choosen file
 function deleteFile(ele,filename){
  //alert($(ele).parent().parent().parent().html());
 $(ele).parent().parent().parent().fadeOut(300);
   var innerval5= $("#fileNum").html();
  var btnVal = innerval5 - 1 ;
  $("#fileNum").html(btnVal);
  $.ajax({
    url: '{{ route('templates.deleteFile') }}',
    type: 'POST',
    dataType: 'json',
    data: {filename: filename, _token: '{{ csrf_token() }}', template_id: {{ $template->id }} },
  })
  .done(function(data) {
    if(data.status=="success")
    {
      var files  = $('#files').val();
      files = JSON.parse(files);
      var index = files.indexOf(filename);
      if (index >= 0) {
        files.splice( index, 1 );
      }
      //newfile = files.remove(filename);
      $('#files').val(JSON.stringify(files));

    }
  });
  
  }
</script>
  <!-- Mail Template Submit -->
  @component('components.form-submit')
      @slot('form')
          mail-form
      @endslot

      @slot('redirect')
        {{ route('templates.detail',['id'=>base64_encode($template->module->id)]) }}
      @endslot
  @endcomponent
  <!-- myModal-preview Modal JS-->
  <script>
    $("#myModal-preview").on('shown.bs.modal', function (e) {
      var files = $('#files').val();
      var html = '';
      if(files)
      files = JSON.parse(files);
      {
        $.each(files, function(index, val) {
           html += '<a href="{{ asset('') }}storage/attachements/'+val+'" target="_blank">'+val+'</a> | ';
        });
      }
      
        $('#att-arr').html(html);
        var wysiwygeditor = $('#wysiwygeditor').html();
        $('#wysiwygprv').html(wysiwygeditor);
    });

    function submitTemplate() {
      var wysiwygeditor = $('#wysiwygeditor').html();
      var to_input = $('#to-input').val();
      var cc_input = $('#cc-input').val();
      var bcc_input = $('#bcc-input').val();
      $('#wysiwygtext').val(wysiwygeditor);
      $('#totext').val(to_input);
      $('#cctext').val(cc_input);
      $('#bcctext').val(bcc_input);
      $('#mail-form').submit();
    }
  </script>
@endsection