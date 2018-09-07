@extends('layouts.master')

@section('content')
<div class="content-wrapper">

  <div class="row">
    <div class="col-sm-9">
     <div class="panel panel-default panel_user">
       <div class="panel-body" style="position: relative;">
        <div class="edit_box">
          <a href="{{ route('teams.profile') }}"><em class="fa fa-edit"></em></a>
        </div>
        <div class="row row-table">
         <div class="col-xs-5 div_user_img">
          <img src="{{ (file_exists($lead->image)) ? asset($lead->image) : asset('img/user/8.jpg') }}" alt="Image" class="img-circle thumb170">
          <div class="user_names">{{ $lead->first_name }} {{ $lead->last_name }}</div>
        </div>
        <div class="col-xs-7">
          <ul class="list-unstyled">
           <li class="mb-md">
             <div class="li-cel col-xs-5"> <em class="fa fa-envelope fa-fw"></em>Email </div> 
             <div class="li-cel col-xs-7"> {{ $lead->email }}</div></li>
             <li class="mb-md">
              <div class="li-cel col-xs-5">  <em class="fa fa-phone fa-fw"></em>Phone </div> 
              <div class="li-cel col-xs-7"> {{ $lead->phone }}</div>
            </li>
            <li class="mb-md">
              <div class="li-cel col-xs-5"> <em class="icon-paper-plane fa-fw"></em>Visa type </div>
              <div class="li-cel col-xs-7"> @if($lead->visa_id) {{ $lead->visa->name }} @endif</div>
            </li>
            <li class="mb-md">
              <div class="li-cel col-xs-5"> <em class="fa fa-home fa-fw"></em> Address </div>
              <div class="li-cel col-xs-7"> {{ $lead->address }} </div>
            </li>
            <li class="mb-md">

              <div class="li-cel col-xs-5"> <em class="fa fa-tasks fa-fw"></em>Assigned to </div>
              <div class="li-cel col-xs-7"> @if($lead->user_id) {{ $lead->user->first_name }} {{ $lead->user->last_name }} @endif</div>
            </li>
          </ul>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-2 col-sm-offset-1">
          <div class="icon_box text-center">
            @if($lead->status >= 1)
            <em class="fa fa-check fa-fw panel-color5"></em>
            @else
            <label for="prequalify"><em class="fa fa-clock-o fa-fw panel-color5"></em></label>
            <input type="checkbox" id="prequalify" class="hide" value="1" onchange="leadStatus({{ $lead->id }})">
            <form action="{{ route('leads.status',['id'=>$lead->id]) }}" method="post" id="lead-status{{ $lead->id }}">
            @csrf
            @method('put')
            <input type="hidden" name="id" value="{{ $lead->id }}">
            <input type="hidden" name="status" value="1">
            </form>
            @endif
            <p>Prequalify </p>
          </div>
        </div>
        <div class="col-xs-2">
          <div class="icon_box text-center">
            @if($lead->status >= 2)
            <em class="fa fa-check fa-fw panel-color2"></em>
            @else
            <label for="qualify"><em class="fa fa-certificate fa-fw panel-color2"></em></label>

              <input type="checkbox" id="qualify" class="hide" value="2" @if($lead->user_id) onchange="leadStatus({{ $lead->id }})" @else onchange="swal('Warning','Please assign this lead to a user','warning')"  @endif>
              <form action="{{ route('leads.status',['id'=>$lead->id]) }}" method="post" id="lead-status{{ $lead->id }}">
              @csrf
              @method('put')
              <input type="hidden" name="id" value="{{ $lead->id }}">
              <input type="hidden" name="status" value="2">
              </form>
              
            @endif
            <p>Qualify</p>
          </div>
        </div>
        <div class="col-xs-2">
          <div class="icon_box text-center">
            <em class="fa fa-file-text-o fa-fw panel-color3"></em>
            <p>Application </p>
          </div>
        </div>
        <div class="col-xs-2">
          <div class="icon_box text-center">
            <em class="fa fa-paper-plane-o fa-fw panel-color4"></em>
            <p>Visa launch </p>
          </div>
        </div>
        <div class="col-xs-2">
          <div class="icon_box text-center">
            <em class="fa fa-line-chart fa-fw panel-color1"></em>
            <p>Result </p>
          </div>
        </div>

      </div>

      {{-- <div class="acti_deacti">
        <button class="btn btn-sm btn-success">Active</button>
      </div> --}}

    </div>
  </div>

<div class="row">
  <div class="col-sm-12">
    <div class="panel panel-default">
     <div class="panel-body">

      <div class="row" style="padding-bottom: 15px;">
        <div class="col-sm-12">
          <a href="#" class="btn btn-sm btn-info pull-right" data-toggle="modal" data-target="#email_modal_add">Message to agent</a>
        </div>
      </div>

       <div class="table-responsive">
         <table class="table table-striped table-hover">
           <thead>
             <tr>
               <th>Date - Time </th>
               <th>Email subject</th>
               <th>Created by</th>
               <th>Action</th>
             </tr>
           </thead>
           <tbody id="myTable">
          @foreach($email_logs as $row)
            <tr>
             <td>{{ $row->created_at->format('d-m-Y h:i:s a') }}</td>
             <td><a href="{{ route('emaillogs.show',['id'=>base64_encode($row->id)]) }}">{{ $row->subject }}</a></td>
             <td>{{ $row->user->first_name }} {{ $row->user->last_name }}</td>
            {{--  <td><button class="btn btn-default" @if($row->user_id==Auth::id()) onclick="updateStatus({{ $row->id }})" @else disabled="" @endif><i class="fa fa-trash fa-2x text-danger"></i></button> </td>
             <form action="{{ route('emaillogs.update',['id'=>$row->id]) }}" method="post" id="form-status{{ $row->id }}" style="display: none;">
             @csrf
             @method('put')
             <input type="hidden" name="id" value="{{ $row->id }}">
             <input type="hidden" name="status" value="{{ $row->status }}">
             </form> --}}
             <td><a href="{{ route('emaillogs.show',['id'=>base64_encode($row->id)]) }}" class="btn btn-xs btn-purple">Read more</a></td>
           </tr>
          @endforeach
          @if (count($email_logs) === 0)
              <tr><td colspan="4">No data found!</td></tr>
          @endif
         </tbody>
       </table>
     </div>



   </div>
 </div>
</div>
</div>    

</div>


<div class="col-sm-3">
  <div style="margin-top: 44px;">

         <!--   <div class="panel widget widg_c">
             <div class="row row-table row-flush">
                <div class="col-xs-2 rightmenu_f text-center">
                   <em class="fa fa-comments fa-2x" style="color:#73ca79"></em>
                </div>
                <div class="col-xs-10">
                   <div class="panel-body text-left pd1">
                      <h4 class="mt0">Start communication 
                        <a href="start-communication.html" class="pull-right">
                   <em class="icon-arrow-right-circle "></em>
                </a></h4>
                    
                   </div>
                </div>
             </div>
           </div> -->

           <!-- row  end -->
           <div class="panel widget widg_c">
             <div class="row row-table row-flush">
              <div class="col-xs-2 rightmenu_f text-center">
               <canvas class="loader4"></canvas>
             </div>
             <div class="col-xs-10">
               <div class="panel-body text-left pd1">
                <h4 class="mt0">Application <a href="{{ route('leads.application',['lead'=>base64_encode($lead->id)]) }}" class="pull-right">
                 <em class="icon-arrow-right-circle"></em>
               </a></h4>
               <p class="mb0 text-muted"></p>
             </div>
           </div>
         </div>
       </div>

       <!-- row  end -->
       {{-- <div class="panel widget widg_c">
         <div class="row row-table row-flush">
          <div class="col-xs-2 rightmenu_f text-center">
           <em class="fa fa-file-text-o fa-2x" style="color:#3dbace"></em>
         </div>
         <div class="col-xs-10">
           <div class="panel-body text-left pd1">
            <h4 class="mt0">Invoice
              <a href="{{ route('invoices.index',['lead'=>base64_encode($lead->id)]) }}" class="pull-right">
               <em class="icon-arrow-right-circle "></em>
             </a><br>
             <small></small>
           </h4>

         </div>
       </div>
     </div>
   </div> --}}
   <!-- row  end -->

   <div class="panel widget widg_c">
    <div class="row row-table row-flush">
       <div class="col-xs-2 rightmenu_f text-center">
          <em class="fa fa-file-text-o fa-2x" style="color:#3dbace"></em>
       </div>
       <div class="col-xs-10">
         @foreach($invoices as $row)
         @php
           $subtot = array();
           $paytot = array();
         @endphp
         @foreach($row->services as $srv)
           @php
             $subtot[] = $srv->hrs * $srv->rate;
           @endphp
         @endforeach
         @foreach($row->payment_records as $pr)
            @php
              $paytot[] = $pr->amount;
            @endphp
          @endforeach
          @if( (array_sum($subtot) - array_sum($paytot) > 0) )
          <div class="panel-body text-left pd1 pd2">
             <h4 class="mt0">Invoice  <span class="label label-danger">Pending  <em class="fa fa-close mr"></em></span><a href="{{ route('invoices.index',['lead'=>base64_encode($lead->id)]) }}" class="pull-right in-li"><em class="icon-arrow-right-circle "></em></a><br>
       <small>No : {{ $row->invoice_no }} / {{ $row->updated_at->format('d/m/Y') }} / $ {{ array_sum($subtot) }}</small>
       </h4>
           
          </div>
          @endif
         @endforeach

         @if($invoices->count()===0)
            <div class="panel-body text-left pd1 pd2">
               <h4 class="mt0">Invoice  <a href="{{ route('invoices.index',['lead'=>base64_encode($lead->id)]) }}" class="pull-right in-li"><em class="icon-arrow-right-circle "></em></a>
         </h4>
             
            </div>
         @endif

       </div>
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
  .edit_box {
      position: absolute;
      right: 36px;
      font-size: 26px;
  }
  </style>
@endsection
@section('custom_js')

<!-- Modal -->
<div class="modal fade" id="email_modal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" action="{{ route('emaillogs.store') }}" class="form-horizontal" id="email-modal-edit">
      @csrf
      <input type="hidden" name="lead_id" value="{{ $lead->id }}">
      <input type="hidden" name="template_id">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">
            Edit on it
          </h4>
        </div>
        <div class="modal-body">
         <div class="form-group form_m0 loop_mail">
           <label class="control-label col-sm-1 ll_f">
            To
          </label>
          <div class="col-sm-9">
            <input type="text" placeholder="To" class="form-control b0" name="to" value="{{ $lead->email }}" readonly="">
          </div>
          <div class="col-sm-2">

            <span class="input-group-addon add_cc" style="background-color:transparent;border: none; cursor: pointer;">Cc</span>
            <span class="input-group-addon add_bcc" style="background-color:transparent;border: none; cursor: pointer;">Bcc</span>

          </div>

        </div>

        <div class="form-group row mrow2" id="cctoggle" style="display: none"> <input type="text" class="form-control " placeholder="Cc :" style="border: none;" id="cc-input" name="cc"></div>
        <div class="form-group row mrow2" id="bcctoggle" style="display: none"> <input type="text" class="form-control " placeholder="Bcc :" style="border: none;" id="bcc-input" name="bcc"></div>

        <div class="form-group  form_m0">
         <label class="control-label col-sm-1 ll_f">
           Subject
         </label>
         <div class="col-sm-11">
          <input type="text" placeholder="Subject" class="form-control b0" name="subject">
        </div>
      </div>
      <div class="form-group row mrow">
        <strong> Attachments: </strong>
        <span id="att-arr"></span>
      </div>
      <div class="form-group ">
       <div class="col-sm-12">
         <input type="text" placeholder="Header" value="Dear {{ $lead->first_name }} {{ $lead->last_name }}," class="form-control b0" readonly="">
       </div>
     </div>

     <div class="form-group  form_m0">
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
         <div contenteditable="true" placeholder="Enter text here..." style="overflow:scroll; height:250px;max-height:250px" class="form-control wysiwyg mt-lg" id="wysiwygeditor"></div>

       </div>
     </div>
     <textarea name="content" style="display: none"></textarea>
     <div class="form-group">
      <div class="col-sm-6">
       <label class="control-label"> Attach file</label>
       <input type="file" name="file[]" class="form-control filestyle"  multiple="">
       <textarea name="old_files" style="display: none"></textarea>
     </div>
   </div>
   <div class="form-group">
     <div class="col-sm-12">
       <label class="control-label">
        Regards
      </label>
      <input type="text" placeholder="Subject" value="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}" name="regards" class="form-control b0">
    </div>
  </div>

</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  <button type="Submit" class="btn btn-info" >Post <i class="fa fa-paper-plane"></i></button>
</div>
</form>
</div>
</div>
</div>

<!-- Edit Email Modal JS-->
<script>
  $(".add_cc").click(function(event) {
   $("#cctoggle").toggle();
  });

  $(".add_bcc").click(function(event) {
   $("#bcctoggle").toggle();
  });

  $("#email_modal").on('shown.bs.modal', function (e) {
      var id = $(e.relatedTarget).data('id');
      $.ajax({
        url: '{{ route('leads.getmodal') }}',
        type: 'POST',
        dataType: 'json',
        data: {id: id, '_token': '{{ csrf_token() }}'}
      })
      .done(function(data) {
        $('#wysiwygeditor').html(data.mailtemplate.content);
        $('#email_modal [name=cc]').val(data.mailtemplate.cc);
        $('#email_modal [name=bcc]').val(data.mailtemplate.bcc);
        $('#email_modal [name=subject]').val(data.subject);
        $('#email_modal textarea[name=old_files]').val(data.mailtemplate.files);
        $('#email_modal [name=template_id]').val(data.id);
        var html = '';
        var files = JSON.parse(data.mailtemplate.files);
          $.each(files, function(index, val) {
             html += '<a href="{{ asset('') }}storage/attachements/'+data.id+'/'+val+'" target="_blank">'+val+'</a> | ';
          });
          $('#att-arr').html(html);
      });
      
  });
</script>

<!-- Modal -->
<div class="modal fade" id="email_modal_add" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form method="post" action="{{ route('emaillogs.store') }}" class="form-horizontal" id="email-modal-add">
      @csrf
      <input type="hidden" name="lead_id" value="{{ $lead->id }}">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">
            Add new one
          </h4>
        </div>
        <div class="modal-body">
         <div class="form-group form_m0 loop_mail">
           <label class="control-label col-sm-1 ll_f">
            To
          </label>
          <div class="col-sm-9">
            <input type="text" placeholder="To" value="{{ $lead->user->email }}" class="form-control b0" name="to" readonly="">
          </div>
          <div class="col-sm-2">

            <span class="input-group-addon add_cc2" style="background-color:transparent;border: none; cursor: pointer;">Cc</span>
            <span class="input-group-addon add_bcc2" style="background-color:transparent;border: none; cursor: pointer;">Bcc</span>

          </div>

        </div>

        <div class="form-group row mrow2" id="cctoggle2" style="display: none"> <input type="text" class="form-control " placeholder="Cc :" style="border: none;" id="cc-input2" name="cc"></div>
        <div class="form-group row mrow2" id="bcctoggle2" style="display: none"> <input type="text" class="form-control " placeholder="Bcc :" style="border: none;" id="bcc-input2" name="bcc"></div>

        <div class="form-group  form_m0">
         <label class="control-label col-sm-1 ll_f">
           Subject
         </label>
         <div class="col-sm-11">
          <input type="text" placeholder="Subject" name="subject" class="form-control b0">
        </div>
      </div>
      <div class="form-group ">
       <div class="col-sm-12">
        <input type="text" placeholder="" value="Dear {{ $lead->first_name }} {{ $lead->last_name }}," class="form-control b0" readonly="">
      </div>
    </div>

    <div class="form-group  form_m0">
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
      <div contenteditable="true" placeholder="Enter text here..." style="overflow:scroll; height:250px;max-height:250px" class="form-control wysiwyg mt-lg" id="wysiwygeditor_add"></div>
              
     </div>
   </div>
   <textarea name="content" class="hide"></textarea>
   <div class="form-group">
    <div class="col-sm-6">
     <label class="control-label"> Attach file</label>
     <input type="file" name="file[]" class="form-control filestyle"  multiple="">
   </div>
 </div>

 <div class="form-group">
   <div class="col-sm-12">
     <label class="control-label">
      Regards
    </label>
    <input type="text" placeholder="Subject" value="{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}" class="form-control b0">
  </div>
</div>

</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
  <button type="Submit" class="btn btn-info" >Post <i class="fa fa-paper-plane"></i></button>
</div>
</form>
</div>
</div>
</div>

<script>
  $(".add_cc2").click(function(event) {
   $("#cctoggle2").toggle();
  });

  $(".add_bcc2").click(function(event) {
   $("#bcctoggle2").toggle();
  });
</script>

 <!-- =============== PAGE VENDOR SCRIPTS ===============-->
 <script src="{{ asset('js/bootstrap-filestyle.js') }}"></script>
 <!-- CLASSY LOADER-->
 <script src="{{ asset('js/jquery.classyloader.js') }}"></script>
 <!-- WYSIWYG-->
 <script src="{{ asset('js/bootstrap-wysiwyg.js') }}"></script>
 <script src="{{ asset('js/jquery.hotkeys.js') }}"></script>
 <!-- MOMENT JS-->
 <script src="{{ asset('js/moment-with-locales.min.js') }}"></script>
  <!-- DATETIMEPICKER-->
 <script type="text/javascript" src="{{ asset('js/bootstrap-datetimepicker.min.js') }}">
 </script>
 <script src="{{ asset('js/demo/demo-forms.js') }}"></script>

 <script type="text/javascript">
   $(document).ready(function() {
      $('.loader4').ClassyLoader({
         width: 40, // width of the loader in pixels
         height: 40, // height of the loader in pixels
         speed: 20,
         diameter: 15,
         fontSize: '10px',
         fontFamily: 'Georgia',
         fontColor: 'rgba(0,0,0,0.4)',
         lineColor: '#f1c448',
         percentage: 79,
         remainingLineColor: 'rgba(0,0,0,0.1)'
     });
   });
 </script>


 <!-- hidden div for send mail to more  -->
 <div class="loop_dat" style="display: none;">
    <div class="form-group form_m0">
 <label class="control-label col-sm-1 ll_f">
 To
 </label>
 <div class="col-sm-11">
 <input type="text" placeholder="To" value="" class="form-control b0">
 </div>
 </div>
 </div>
 
 <!-- Mail Template Modal Edit Submit -->
 <script>
   $('#email-modal-edit').submit(function(event) {
     event.preventDefault();
     $('#email-modal-edit .modal-footer').html('<i class="fa fa-spin fa-refresh"></i> Email is sending');
     var content = $('#wysiwygeditor').html();
     $('#email-modal-edit textarea[name=content]').val(content);
     var form = document.getElementById('email-modal-edit');
     fd = new FormData(form);
     $.ajax({
       url: $(this).attr('action'),
       type: 'POST',
       dataType: 'json',
       data: fd,
       processData: false,
       contentType: false
     })
     .done(function(data) {
       if(data.status=="error")
       {
         $.notify(data.msg);
       }
       else
       {
         sweetAlert({
            title:'Success!',
            text: data.msg,
            type:'success'
          },
          function(isConfirm){
             location.href="{{ route('customer.index') }}";
           });
       }
     });
     
   });
 </script>
 <!-- Mail Template Modal Add Submit -->
 <script>
   $('#email-modal-add').submit(function(event) {
     event.preventDefault();
     $('#email-modal-add .modal-footer').html('<i class="fa fa-spin fa-refresh"></i> Email is sending');
     var content = $('#wysiwygeditor_add').html();
     $('#email-modal-add textarea[name=content]').val(content);
     var form = document.getElementById('email-modal-add');
     fd = new FormData(form);
     $.ajax({
       url: $(this).attr('action'),
       type: 'POST',
       dataType: 'json',
       data: fd,
       processData: false,
       contentType: false
     })
     .done(function(data) {
       if(data.status=="error")
       {
         $.notify(data.msg);
       }
       else
       {
         sweetAlert({
            title:'Success!',
            text: data.msg,
            type:'success'
          },
          function(isConfirm){
             location.href="{{ route('customer.index') }}";
           });
       }
     });
     
   });
 </script>
 <!-- Status-->
 @component('components.status-delete-js')
 @slot('form')
     form-status
 @endslot
 @slot('title')
     updateStatus
 @endslot
 @endcomponent

 <!-- Status-->
 @component('components.status-delete-js')
 @slot('form')
     lead-status
 @endslot
 @slot('title')
     leadStatus
 @endslot
 @endcomponent
 
@endsection