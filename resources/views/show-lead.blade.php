@extends('layouts.master')

@section('content')
<div class="content-wrapper">

  <div class="row">
    <div class="col-sm-9">
     <div class="panel panel-default panel_user">
       <div class="panel-body" style="position: relative;">
        <div class="row row-table">
         <div class="col-xs-5 div_user_img">
          <img src="{{ (file_exists(asset($lead->image))) ? asset($lead->image) : asset('img/user/8.jpg') }}" alt="Image" class="img-circle thumb170">
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
            <input type="checkbox" id="qualify" class="hide" value="2" onchange="leadStatus({{ $lead->id }})">
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

      <div class="acti_deacti">
        <button class="btn btn-sm btn-success">Active</button>
      </div>

    </div>
  </div>

  <div class="panel panel-default">
    
    <div class="panel-body">
      <div role="tabpanel" style="background-color:#FFFFFF">
        <!-- Nav tabs-->

        <ul role="tablist" class="nav nav-tabs nav-tabs_custome">
          <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">
            <i class="icon-note"></i> &nbsp;&nbsp;New note </a>
          </li>
          <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">
            <em class="fa fa-plus"></em> &nbsp;&nbsp;Log activity</a>
          </li>
          <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">
            <em class="icon-share-alt"></em> &nbsp;&nbsp;Create task</a>
          </li>

          <li role="presentation" id="email_temp"><a href="#email" aria-controls="email" role="tab" data-toggle="tab">
            <em class="fa fa-envelope-o"></em> &nbsp;&nbsp;Email

          </a>
        </li>

          <li role="presentation" id="forms-assign"><a href="#assign-form" aria-controls="assign-form" role="tab" data-toggle="tab">
            <em class="fa fa-cog"></em> &nbsp;&nbsp;Form
          </a>
        </li>

      </ul>

      <!-- Tab panes-->

      <div class="tab-content" style="background-color:#FFFFFF">
        <div id="home" role="tabpanel" class="tab-pane active">
          <form class="form-horizontal" action="{{ route('notes.store') }}" method="post">
          @csrf
            <input type="hidden" name="lead_id" value="{{ $lead->id }}">
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            <textarea class="form-control" rows="8"  placeholder="Start typing to leave a note ......." style="border:none;margin-top:15px;" required="" name="content"></textarea>

            <hr>
            <button type="Submit" class="mb-sm btn btn-success btn-outline" style="margin:10px;">Save</button>
            <button type="reset" class="mb-sm btn btn-warning btn-outline" style="margin:10px;">Discard</button>
          </form>

        </div>
        <div id="profile" role="tabpanel" class="tab-pane">
          <form class="form-horizontal" action="{{ route('activities.store') }}" method="post">
          @csrf
            <input type="hidden" name="lead_id" value="{{ $lead->id }}">
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            <div class="row" style="margin-top:15px;">
              <div class="btn-group col-md-2">
                <select class="form-control" name="log_a_call">
                   <option>Log a call
                   </option>
                   <option>Log an email
                   </option>
                   <option>Log a meeting
                   </option>
                </select>
              </div>

              <div class="btn-group col-md-2">
                <select class="form-control" name="out_come">
                   <option>No answer
                   </option>
                   <option>Busy
                   </option>
                   <option>Wrong number
                   </option>
                    <option>Left live message
                   </option>
                    <option>Left voice call
                   </option>
                    <option>Connected
                   </option>
                </select>
              </div>
              <div class="col-md-4 pull-right">
                <div id="" class="input-group date datetimepicker1">
                  <input type="text" class="form-control" style="border:none; background-color:#FFFFFF" name="datetime" value="{{ date('d/m/Y H:i:s') }}">
                  <span class="input-group-addon" style="border:none; background-color:#FFFFFF">
                    <span class="fa fa-calendar"></span>
                  </span>
                </div>
              </div>
            </div>
            <textarea class="form-control" rows="8"  placeholder="Describe the call ......." style="border:none;margin-top:15px;" name="content"></textarea>
            <hr>
            <button type="Submit" class="mb-sm btn btn-success btn-outline" style="margin:10px;">Save</button>
            <button type="reset" class="mb-sm btn btn-warning btn-outline" style="margin:10px;">Discard</button>
          </form>
        </div>
        <div id="messages" role="tabpanel" class="tab-pane">
          <form class="form-horizontal" action="{{ route('tasks.store') }}" method="post">
          @csrf
            <input type="hidden" name="lead_id" value="{{ $lead->id }}">
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            <div class="row" style="margin-top:15px;">
              <div class="col-md-8">
                <input type="text" placeholder="Enter your task ..." style="border:none;" class="form-control" name="subject" required="">
              </div>
              <div class="col-md-4 pull-right">
                <div id="" class="input-group date datetimepicker1">
                  <input type="text" class="form-control" value="{{ date('d/m/Y H:i:s') }}" style="border:none; background-color:#FFFFFF" name="datetime">
                  <span class="input-group-addon" style="border:none; background-color:#FFFFFF">
                    <span class="fa fa-calendar"></span>
                  </span>
                </div>
              </div>
            </div>
            <hr>
            <textarea class="form-control" rows="8"  placeholder="Notes ..." style="border:none;margin-top:15px;" name="content" required=""></textarea>

            <hr>
            <button type="Submit" class="mb-sm btn btn-success btn-outline" style="margin:10px;">Save</button>
            <button type="reset" class="mb-sm btn btn-warning btn-outline" style="margin:10px;">Discard</button>
          </form>
        </div>

        <div id="email" role="tabpanel" class="tab-pane">
          <div class="row">
            <div class="tab_msg col-sm-3">



              <ul class="side-list" style="-webkit-padding-start: 20px;">
                <li> <a href="#" class="btn btnc btn-primary" data-toggle="modal" data-target="#email_modal_add" >
                  New email  <i class="fa fa-envelope-o"></i></a></li>

                  @foreach($modules as $mod)
                   <li><i class="fa fa-angle-right"></i> <a href="javascript:void(0)" onclick="mail(event, 'id{{ $mod->id }}')" class="tablinks" @if($loop->first) id="defaultOpen" @endif>{{ $mod->name }}</a> </li>
                  @endforeach

                </ul>

              </div>

              @foreach($modules as $mod)
              <!-- msg row start -->
              <div id="id{{ $mod->id }}" class="tabcontent_msg col-sm-9">

                <table class="table table-hover mb-mails">
                  <thead>
                    <tr>
                      <th colspan="3"> {{ $mod->name }}</th>
                      <th class="text-center" style="min-width: 110px">MODIFIED BY</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($mod->templates as $row)
                    <!-- ngRepeat: mail in mails | filter:folder-->
                    <tr>
                      <td>
                        {{-- <div class="checkbox c-checkbox">
                          <label>
                            <input type="checkbox" checked="">
                            <span class="fa fa-check"></span>
                          </label>
                        </div> --}}
                      </td>

                      <td class="text-center checkbox-star attachment_icon attachment_icon">
                        <input type="checkbox" id="starhalf{{ $row->id }}" @if($row->user_id==Auth::id() && $row->favorite==1) checked="" @endif />
                        <label class="half" for="starhalf{{ $row->id }}">
                          <em class="fa fa-star"></em>
                        </label>


                      </td>
                      <td>
                        <div class="mb-mail-meta profile-pic">
                          <div class="pull-left">
                            <div class="mb-mail-subject" data-id="{{ $row->id }}" data-toggle="modal" data-target="#email_modal">{{ $row->name }}</div>
                          </div>
                          <div class="mb-mail-preview">{{ $row->subject }}</div>

                        </div>
                      </td>
                      <td class="text-center">
                        <div class="mb-mail-from"> {{ $row->user->first_name }} {{ $row->user->last_name }}</div>
                        <small>{{ $row->updated_at }}</small>
                      </td>

                    </tr>
                    <!-- end ngRepeat: mail in mails | filter:folder-->
                    @endforeach

                  </tbody>
                </table>

              </div>
              @endforeach
              <!-- msg row end -->

            </div>
          </div>

          <div id="assign-form" role="tabpanel" class="tab-pane">
            <form class="form-horizontal" action="{{ route('leads.categories') }}" method="post">
            @csrf
              <input type="hidden" name="lead_id" value="{{ $lead->id }}">
              <input type="hidden" name="user_id" value="{{ auth()->id() }}">
              <br>
                <div class="col-sm-12">
                  @foreach($categories as $cat)
                    <div class="form-check checkbox c-checkbox">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" name="category_id[]" value="{{ $cat->id }}" @if($lead->category_id) {{ (in_array($cat->id, json_decode($lead->category_id))) ? 'checked' : '' }} @endif>  <span class="fa fa-check"></span>{{ $cat->name }}
                      </label>
                    </div>
                  @endforeach
                </div>
          <div class="clearfix"></div>
              <hr>
              <button type="Submit" class="mb-sm btn btn-success btn-outline" style="margin:10px;">Save</button>
              <button type="reset" class="mb-sm btn btn-warning btn-outline" style="margin:10px;">Discard</button>
            </form>
          </div>


        </div>

      </div>
    </div>

  </div>

<div class="row" id="view_topic_table">
  <div class="col-sm-12">
    <div class="panel panel-default">
     <div class="panel-body">


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
             <td><button class="btn btn-default" @if($row->user_id==Auth::id()) onclick="updateStatus({{ $row->id }})" @else disabled="" @endif><i class="fa fa-trash fa-2x text-danger"></i></button> </td>
             <form action="{{ route('emaillogs.update',['id'=>$row->id]) }}" method="post" id="form-status{{ $row->id }}" style="display: none;">
             @csrf
             @method('put')
             <input type="hidden" name="id" value="{{ $row->id }}">
             <input type="hidden" name="status" value="{{ $row->status }}">
             </form>
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


<ul class="timeline">
@foreach($notes as $row)
 <!-- timeline item-->
 <li style="margin-right:1% !important;">
  <div class="timeline-badge warning" style="background-color:#1A3755">
   <em class="icon-envelope-letter"></em>
 </div>
 <div class="timeline-panel">
   <div class="popover right">
     <div class="popover-title" style="color:#182429;background-color:#FFF; border-bottom:#CECECE .5px solid; height:40px;">
      <span class="pull-right"><a href="#" data-toggle="modal" data-target="#noteModal" data-action="{{ route('notes.update',['id'=>$row->id]) }}" data-content="{{ $row->content }}">Edit</a>&nbsp;&nbsp;<a  href="javascript:void(0)" onclick="deleteNote({{ $row->id }})">Delete</a></span>
      <form action="{{ route('notes.destroy',['id'=>$row->id]) }}" method="post" id="note-delete{{ $row->id }}" style="display: none;">
      @csrf
      @method('delete')
      <input type="hidden" name="id" value="{{ $row->id }}">
      <button class="btn btn-danger" type="submit">Delete</button>
      </form>
    </div>
      <div class="arrow"></div>
      <div class="popover-content">
       <div class="row">
         <div class="col-md-1"><i class="icon-note" style="font-size:25px"></i> </div>
         <div class="col-md-11">{{ $row->content }}<br>
           <span style="color:#81A6B1; font-size:12px; font-weight:100">{{ $row->updated_at->format('F jS, Y \a\t h:i a') }}</span>
         </div>
       </div>
     </div>
   </div>
 </div>
</li>
@endforeach
@foreach($activities as $row)
<!-- timeline item-->
<li style="margin-right:1% !important;">
  <div class="timeline-badge warning" style="background-color:#1A3755">
   <em class="icon-envelope-letter"></em>
 </div>
 <div class="timeline-panel">
   <div class="popover right">
     <div class="popover-title" style="color:#182429;background-color:#FFF; border-bottom:#CECECE .5px solid; height:40px;">

       <span class="pull-right"><a href="#" data-toggle="modal" data-target="#logModal" data-action="{{ route('activities.update',['id'=>$row->id]) }}" data-content="{{ $row->content }}" data-log_a_call="{{ $row->log_a_call }}" data-out_come="{{ $row->out_come }}" data-datetime="{{ $row->datetime }}">Edit</a>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="deleteActivity({{ $row->id }})">Delete</a></span>
       <form action="{{ route('activities.destroy',['id'=>$row->id]) }}" method="post" id="activity-delete{{ $row->id }}" style="display: none;">
       @csrf
       @method('delete')
       <input type="hidden" name="id" value="{{ $row->id }}">
       <button class="btn btn-danger" type="submit">Delete</button>
       </form>
     </div>
       <div class="arrow"></div>
       <div class="popover-content">
         <div class="row">
           <div class="col-md-1"><i class="fa fa-plus" style="font-size:25px"></i> </div>
           <div class="col-md-11">
             <h5>Call outcome : {{ $row->out_come }} </h5>
             {{ $row->content }}<br>
             <span style="color:#81A6B1; font-size:12px; font-weight:100">{{ $row->datetime->format('F jS, Y \a\t h:i a') }}</span>
           </div>
         </div>
       </div>
     </div>
   </div>
 </li>
 @endforeach
 @foreach($tasks as $row)
 <!-- timeline item-->
 <li style="margin-right:1% !important;">
  <div class="timeline-badge warning" style="background-color:#1A3755">
   <em class="icon-envelope-letter"></em>
 </div>
 <div class="timeline-panel">
   <div class="popover right">
     <div class="popover-title" style="color:#182429;background-color:#FFF; border-bottom:#CECECE .5px solid; height:40px;">
      <span class="pull-left"><h4>{{ $row->subject }}</h4></span>
      <span class="pull-right"><a href="#" data-toggle="modal" data-target="#taskModal" data-action="{{ route('tasks.update',['id'=>$row->id]) }}" data-content="{{ $row->content }}" data-subject="{{ $row->subject }}" data-datetime="{{ $row->datetime }}">Edit</a>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="deleteTask({{ $row->id }})">Delete</a></span>
      <form action="{{ route('tasks.destroy',['id'=>$row->id]) }}" method="post" id="task-delete{{ $row->id }}" style="display: none;">
      @csrf
      @method('delete')
      <input type="hidden" name="id" value="{{ $row->id }}">
      <button class="btn btn-danger" type="submit">Delete</button>
      </form>
    </div>
      <div class="arrow"></div>
      <div class="popover-content">
       <div class="row">
         <div class="col-md-1"><i class="icon-share-alt" style="font-size:25px"></i> </div>
         <div class="col-md-11">
          {{ $row->content }}<br>
          <span style="color:#81A6B1; font-size:12px; font-weight:100">{{ $row->datetime->format('F jS, Y \a\t h:i a') }}</span>
        </div>
      </div>
    </div>
  </div>
</div>
</li>
@endforeach
<!-- START timeline item-->
<li class="timeline-end" >
  <a href="javascript:void(0)" class="timeline-badge" style="background-color:#1A3755">
   <em class="fa fa-plus"></em>
 </a>
</li>
<!-- END timeline item-->
</ul>



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
       <div class="panel widget widg_c">
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
   </div>
   <!-- row  end -->

   <div class="panel widget widg_c">
     <div class="row row-table row-flush">
      <div class="col-xs-2 rightmenu_f text-center">
       <em class="fa fa-calendar-minus-o fa-2x" style="color: #f7735e"></em>
     </div>
     <div class="col-xs-10">
       <div class="panel-body text-left pd1">
        <h4 class="mt0">Lorem Ipsum <a href="javascript:void(0)" class="pull-right">
         <em class="icon-arrow-right-circle"></em>
       </a></h4>
       <p class="mb0 text-muted"></p>
     </div>
   </div>
 </div>
</div>
<!-- row  end -->
<div class="panel widget widg_c">
 <div class="row row-table row-flush">
  <div class="col-xs-2 rightmenu_f text-center">
   <em class="fa fa-balance-scale fa-2x" style="color: #f1c448"></em>
 </div>
 <div class="col-xs-10">
   <div class="panel-body text-left pd1">
    <h4 class="mt0">Decision<a href="decision.html" class="pull-right">
     <em class="icon-arrow-right-circle"></em>
   </a></h4>
   <p class="mb0 text-muted"></p>
 </div>
</div>
</div>
</div>
<!-- row  end -->


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
            <input type="text" placeholder="To" value="{{ $lead->email }}" class="form-control b0" name="to" readonly="">
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

<!-- Note Edit Modal -->
<div id="noteModal" tabindex="-1" role="dialog" aria-labelledby="noteModal" aria-hidden="true" class="modal fade">
  <div class="modal-dialog">
   <div class="modal-content">
    <div class="modal-header">
     <button type="button" data-dismiss="modal" aria-label="Close" class="close">
      <span aria-hidden="true">×</span>
    </button>
    <h4 class="modal-title">Edit note</h4>
  </div>
  <form class="form-horizontal" action="#" method="post">
  @csrf
  @method('PUT')
  <input type="hidden" name="user_id" value="{{ auth()->id() }}">
    <div class="modal-body"> 
      {{-- <div class="form-group">
        <div class="col-sm-5">
         <div class="input-group date datetimepicker1">
           <input type="text" class="form-control" name="updated_at" id="notedate">
           <span class="input-group-addon">
            <span class="fa fa-calendar"></span>
          </span>
        </div></div>

      </div> --}}
      <div class="form-group">
       <div class="col-sm-12">
         <textarea class="form-control" rows="3" name="content" placeholder="Notes ..." required=""></textarea>
       </div>
     </div>
   </div>
   <div class="modal-footer">
     <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
     <button type="submit" class="btn btn-primary">Save changes</button>
   </div>
 </form>
</div>
</div>
</div>
<!-- Edit Note Modal JS-->
<script>
  $("#noteModal").on('shown.bs.modal', function (e) {
      var action = $(e.relatedTarget).data('action');
      var content = $(e.relatedTarget).data('content');
      $('#noteModal form').attr('action', action);
      $('#noteModal [name="content"]').val(content);
  });
</script>
<!-- LogModalEdit -->
<div id="logModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal fade">
  <div class="modal-dialog">
   <div class="modal-content">
    <div class="modal-header">
     <button type="button" data-dismiss="modal" aria-label="Close" class="close">
      <span aria-hidden="true">×</span>
    </button>
    <h4 class="modal-title">Edit Log</h4>
  </div>
  <form method="post" action="#" class="form-horizontal">
  @csrf
  @method('PUT')
  <input type="hidden" name="user_id" value="{{ auth()->id() }}">
    <div class="modal-body"> 
      <div class="form-group">
        <div class="col-sm-4">
         <div class="input-group date">
           <input type="text" class="form-control datetimepicker1" name="datetime">
           <span class="input-group-addon">
            <span class="fa fa-calendar"></span>
          </span>
        </div></div>
        <div class="btn-group col-sm-4">
          <select class="form-control" name="log_a_call">
           <option>Log a call
           </option>
           <option>Log an email
           </option>
           <option>Log a meeting
           </option>
         </select>
       </div>
       <div class="btn-group col-sm-4">
        <select class="form-control" name="out_come">
         <option>No answer
         </option>
         <option>Busy
         </option>
         <option>Wrong number
         </option>
         <option>Left live message
         </option>
         <option>Left voice call
         </option>
         <option>Connected
         </option>
       </select>
     </div>
   </div>
   <div class="form-group">
     <div class="col-sm-12">
       <textarea class="form-control" rows="3" name="content" placeholder="Notes ..." required=""></textarea>
     </div>
   </div>
 </div>
 <div class="modal-footer">
   <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
   <button type="submit" class="btn btn-primary">Save changes</button>
 </div>
</form>
</div>
</div>
</div>
<!-- Edit Log Modal JS-->
<script>
  $("#logModal").on('shown.bs.modal', function (e) {
      var action = $(e.relatedTarget).data('action');
      var content = $(e.relatedTarget).data('content');
      var log_a_call = $(e.relatedTarget).data('log_a_call');
      var out_come = $(e.relatedTarget).data('out_come');
      var datetime = $(e.relatedTarget).data('datetime');
      $('#logModal form').attr('action', action);
      $('#logModal [name="content"]').val(content);
      $('#logModal [name="log_a_call"]').val(log_a_call);
      $('#logModal [name="out_come"]').val(out_come);
      $('#logModal [name="datetime"]').val(datetime);
  });
</script>
<!-- TaskModaledit -->
<div id="taskModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal fade">
  <div class="modal-dialog">
   <div class="modal-content">
    <div class="modal-header">
     <button type="button" data-dismiss="modal" aria-label="Close" class="close">
      <span aria-hidden="true">×</span>
    </button>
    <h4 id="myModalLabel" class="modal-title">Edit Task</h4>
  </div>
  <form method="post" action="#" class="form-horizontal">
  @csrf
  @method('PUT')
  <input type="hidden" name="user_id" value="{{ auth()->id() }}">
    <div class="modal-body"> 
      <div class="form-group">
        <div class="col-sm-5">
         <div class="input-group date">
           <input type="text" class="form-control datetimepicker1" name="datetime" placeholder="07/26/2017 3:53 PM">
           <span class="input-group-addon">
            <span class="fa fa-calendar"></span>
          </span>
        </div></div>

      </div>
      <div class="form-group">
       <div class="col-sm-12">
        <input type="text" name="subject" placeholder="Enter your task ..." class="form-control" required="">
      </div>
    </div>
    <div class="form-group">
     <div class="col-sm-12">
       <textarea class="form-control" rows="3" name="content" placeholder="Notes ..." required=""></textarea>
     </div>
   </div>
 </div>
 <div class="modal-footer">
   <button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
   <button type="submit" class="btn btn-primary">Save changes</button>
 </div>
</form>
</div>
</div>
</div>
<!-- Edit Task Modal JS-->
<script>
  $("#taskModal").on('shown.bs.modal', function (e) {
      var action = $(e.relatedTarget).data('action');
      var content = $(e.relatedTarget).data('content');
      var subject = $(e.relatedTarget).data('subject');
      var datetime = $(e.relatedTarget).data('datetime');
      $('#taskModal form').attr('action', action);
      $('#taskModal [name="content"]').val(content);
      $('#taskModal [name="subject"]').val(subject);
      $('#taskModal [name="datetime"]').val(datetime);
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


 <!-- mail tabs   -->
 <script>
 function mail(evt, cityName) {
     var i, tabcontent, tablinks;
     tabcontent = document.getElementsByClassName("tabcontent_msg");
     for (i = 0; i < tabcontent.length; i++) {
         tabcontent[i].style.display = "none";
     }
     tablinks = document.getElementsByClassName("tablinks");
     for (i = 0; i < tablinks.length; i++) {
         tablinks[i].className = tablinks[i].className.replace(" active", "");
     }
     document.getElementById(cityName).style.display = "block";
     evt.currentTarget.className += " active";
 }

 // Get the element with id="defaultOpen" and click on it
 document.getElementById("defaultOpen").click();
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

 <script type="text/javascript">
   $(document).ready(function() {
     $('#view_topic_table').hide();
     $('#mor_eml').click(function() {
      var M_msg = $('.loop_dat').html();
       $('.loop_mail').after(M_msg);
     });

 // for hide the  table
     $('.nav-tabs_custome a').click(function() {
       $('.timeline').show();
          $('#view_topic_table').hide();
     });
      $('#email_temp a').click(function() {
         $('.timeline').hide();
         $('#view_topic_table').show();
     });
     
   });
 </script>
 <!-- TaskDelete-->
 @component('components.status-delete-js')
   @slot('form')
       task-delete
   @endslot
   @slot('title')
       deleteTask
   @endslot
 @endcomponent
 <!-- NoteDelete-->
 @component('components.status-delete-js')
   @slot('form')
       note-delete
   @endslot
   @slot('title')
       deleteNote
   @endslot
 @endcomponent
 <!-- ActivityDelete-->
 @component('components.status-delete-js')
   @slot('form')
       activity-delete
   @endslot
   @slot('title')
       deleteActivity
   @endslot
 @endcomponent
 
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
             location.href="{{ route('leads.show',['id'=>base64_encode($lead->id)]) }}";
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
             location.href="{{ route('leads.show',['id'=>base64_encode($lead->id)]) }}";
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