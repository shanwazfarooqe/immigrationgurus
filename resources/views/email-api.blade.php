@extends('layouts.master')

@section('content')
@if(LaravelGmail::check())
<section>
 <div class="content-wrapper">
   <div class="row">
     <div class="col-sm-6"> <h3 class="mail-h">MailBox</h3></div>
     <div class="col-sm-6">
      <div class="pull-right">
        <div class="dropdown m-n1">
          <a href="javascript:void(0)" class=" dropdown-toggle" id="menu1" 
          data-toggle="dropdown">
          <img src="{{ asset('img/user/13.jpg') }}" alt="Avatar" width="60" height="60" class="img-thumbnail img-circle">
        </a>
        <ul class="dropdown-menu dropdown-menu-right user-drop" role="menu" aria-labelledby="menu1">
          <li role="presentation"><div class="card-user">
            <img src="{{ asset('img/user/13.jpg') }}" alt="IMG" class="">
            {{-- <h4>Faris Kp</h4> --}}
            <p>{{-- <span class="title-user">Admin</span><br> --}}{{ LaravelGmail::user() }}</p>
            <p><a href="{{ url('oauth/gmail/logout') }}" class="button-user">Logout</a></p>
          </div></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<div class="table-grid table-grid-desktop">
 <div class="col col-md">
  <div class="pr">
   <div class="clearfix mb">
    <button type="button" data-toggle="collapse" data-target=".mb-boxes" class="btn btn-sm btn-default mb-toggle-button pull-right dropdown-toggle">
     <em class="fa fa-bars fa-fw fa-lg"></em>
   </button>
   <a  class="btn btn-purple btn-sm mb-compose-button" data-toggle="modal" href='#message-m'>
     <em class="fa fa-pencil"></em>
     <span>Compose</span>
   </a>
 </div>
 <!-- START mailbox list-->
 <div class="mb-boxes collapse">
  <div class="panel panel-default">
   <div class="panel-body">
    <ul class="nav nav-pills nav-stacked">
     <li class="p">
      <small class="text-muted">MAILBOXES</small>
    </li>
    <li class="active">
      <a href="{{ route('gmail') }}">
       <span class="label label-green pull-right">{{ $inbox }}</span>
       <em class="fa fa-fw fa-lg fa-inbox"></em>
       <span>Inbox</span>
     </a>
   </li>
   <li>
    <a href="#">
     <span class="label label-green pull-right">0</span>
     <em class="fa fa-fw fa-lg fa-paper-plane-o"></em>
     <span>Sent</span>
   </a>
 </li>
 <li>
  <a href="#">
   <span class="label label-green pull-right">5</span>
   <em class="fa fa-fw fa-lg fa-edit"></em>
   <span>Draft</span>
 </a>
</li>

</ul>
</div>
</div>
</div>
<!-- END mailbox list-->
</div>
</div>
<div class="col">
  <!-- START action buttons-->

  <div class="clearfix mb">
   <div class="btn-group pull-left">
    <button type="button" class="btn btn-default btn-sm" id="Dlt-all" onclick="deleteAllMessage()">
     <em class="fa fa-trash"></em> Delete all selected
   </button>
 </div>

@if(!session('prev'))
 @php
   $prevtoken = array();
   $prevtoken[] = $pageToken;
   $key = 0;
 @endphp
 @else
 @php
   $prevtoken = session('prev');
   if (!in_array($pageToken, $prevtoken)) {
     $prevtoken[] = $pageToken;
   }

   $key = array_search($pageToken, $prevtoken);
 @endphp
@endif

@php
  session(['prev'=>$prevtoken]);
  if($key>0)
  {
    $key = $key-1;
  }
@endphp

 <div class="pagination2">
  @if($pageToken)
  <a href="{{ route('gmail',['pageToken'=>$prevtoken[$key]]) }}">❮</a>
  @endif
  @if($gmails['nextPageToken'])
  <a href="{{ route('gmail',['pageToken'=>$gmails['nextPageToken']]) }}">❯</a>
  @endif

  @php
    if(!$pageToken)
    {
      Session::forget('prev');
      $prevtoken2 = array();
      $prevtoken2[] = $pageToken;
      session(['prev'=>$prevtoken2]);
    }
  @endphp
</div>


</div>
<!-- END action buttons-->
<div class="panel panel-default">
 <div class="panel-body">
  <!-- p.lead.text-centerNo mails here-->
  <table class="table table-hover mb-mails">
   <tbody>

   @foreach ( $gmails['messages'] as $row )
   @php

    $filtered = LaravelGmail::message()->get($row['id']);

   @endphp
    <tr>
     <td>

      <div class="checkbox c-checkbox">
       <label>
        <input type="checkbox" name="mail_id[]" value="{{ $row['id'] }}">
        <span class="fa fa-check"></span>
      </label>
    </div>

  </td>
  <td class="text-center">

  </td>
  <td class="mail-main">

    <div class="mb-mail-date pull-right">{{ $filtered->getDate()->diffForHumans() }}</div>
    <a href="{{ route('gmail.detail',['id'=>$row['id']]) }}" class="maincontent">
      <div class="mb-mail-meta">
       <div class="pull-left">
        <div class="mb-mail-subject">{{ $filtered->getSubject() }}</div>
        <div class="mb-mail-from">{{ $filtered->getFromName() }}</div>
      </div>
      {{-- <div class="mb-mail-preview">Fusce gravida, diam ac adipiscing pretium, sem nibh bibendum diam, non consequat quam metus non nunc</div> --}}
    </div>
  </a> <a href="javascript:void(0)" title="Delete mail" data-toggle="tooltip" class="mail-dlt" onclick="deleteMessage('{{ $row['id'] }}')"><i class="fa fa-trash fa-2x"></i> </a>
  <form action="{{ route('gmail.delete',['id'=>$row['id']]) }}" method="post" id="gmail-delete{{ $row['id'] }}" style="display: none;">
  @csrf
  @method('delete')
  <input type="hidden" name="id" value="{{ $row['id'] }}">
  <button class="btn btn-danger" type="submit">Delete</button>
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
</div>
</section>
@endif
@endsection

@section('custom_js')
    <div class="modal fade" id="message-m">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">New message</h4>
          </div>
          <div class="modal-body">
            <form  class="form-horizontal" enctype="multipart/form-data" id="msgform">
             <div class="form-group">
               <div class="col-sm-12">
                 <label class=" control-label">Subject</label>
                 <input type="text" class="form-control" placeholder="Subject"
                 name="subject" />
               </div>
             </div>


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
   <div class="col-sm-4">
    <button type="submit" class="btn btn-info">Send</button>
  </div>
  <div class="col-sm-8 ">
   <label for="fileToUpload" style=" cursor:pointer;" class=" btn btn-purple btn-xs pull-right">
     <em class="icon-paper-clip" style=" font-size:20px;" title="Attach" data-toggle="tooltip"></em>
   </label>
   <input type="file" id="fileToUpload" multiple="" name="fileToUpload" class="hide" />
  </div>
  </div> 
  </form>
  </div>
  </div>
  </div>
  </div>

  <form action="{{ route('gmail.trashAll') }}" method="post" id="gmail-deleteall" style="display: none">
  @csrf
  @method('delete')
  <textarea name="ids" id="ids" class="hide"></textarea>
  </form>

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
        $('#Dlt-all').css('visibility', 'hidden');

        var delbtn=$('.c-checkbox input');
        delbtn.change(function() {
        if (delbtn.is(':checked')) {
        $('#Dlt-all').css('visibility', 'visible');
         }
         else
         {
         $('#Dlt-all').css('visibility', 'hidden');
         }
        
       });
       });
     </script>
     <!-- TaskDelete-->
     @component('components.status-delete-js')
       @slot('form')
           gmail-delete
       @endslot
       @slot('title')
           deleteMessage
       @endslot
     @endcomponent

     <!-- TaskDeleteAll-->
     <script>
      

     function deleteAllMessage() {
      var ids = [];
      $.each($('input[name="mail_id[]"]:checked'), function(index, val) {
         /* iterate through array or object */
         ids.push($(val).val());
      });

      $('#ids').val(JSON.stringify(ids));

       //event.preventDefault();
       sweetAlert({
         title: "Are you sure?",
         /*text: "You will not be able to recover this banner!",*/
         type: "warning",
         showCancelButton: true,
         confirmButtonColor: "#DD6B55",
         confirmButtonText: "Yes",
         cancelButtonText: "No",
         closeOnConfirm: true,
         closeOnCancel: false
       },
       function(isConfirm){
         if (isConfirm) {
           $('#gmail-deleteall').submit();
         } else {
             sweetAlert('Cancelled!', "", "success");
         }
       });
     }
     </script>

@endsection