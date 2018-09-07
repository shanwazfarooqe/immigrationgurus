@extends('layouts.master')

@section('content')
<div class="content-wrapper">

 <div class="content-heading">
  <span><i class="fa fa-commenting-o"></i>  {{ $emaillog->subject }}</span> 
</div>

<div class="panel panel-default">
  <div class="panel-body">
    <div class="row">
     <div class="col-sm-4 col-sm-offset-7"> 
       <input type="text" name="" class="form-control" placeholder="Save copy to">
     </div>
     <div class="col-sm-1"> 
       <button class="btn btn-info " type="submit">Go</button>
     </div>
   </div>
   <hr>


   <div class="row msg_row">
     <div class="col-sm-12">
      <div class="user_mg_row">
        <div class="user_mg_col">
          <div class="name_circle">{{ $emaillog->user->first_name[0] }}</div>
        </div>
        <div class="user_mg_col">
          <h5>{{ $emaillog->user->first_name }} {{ $emaillog->user->last_name }} <small>{{ $emaillog->created_at->format('d-m-Y h:i:s a') }}</small>
          </h5>
          <p>
            {!! $emaillog->content !!}
          </p>

        </div>
      </div>

      <!-- attachment row -->
      <div class="row">
        @if(!empty(json_decode($emaillog->files)))
        @foreach(json_decode($emaillog->files) as $file)
       <div class="col-sm-2">
         <div class="file-icon-c2 text-center">  

           <div class="boxdus">
             <i class="fa fa-file-text-o"></i>
             @php
               $fileArr = explode('/', $file);
             @endphp
             <p>{{ $fileArr[count($fileArr)-1] }} <br><span></span></p>
           </div>
           <div class="row rowcmc">
             <div class="col-sm-12 footerlist-attach">
               <a download href="{{ asset($file) }}" title="Download">
                 <i class="fa fa-cloud-download"></i></a>
                 {{-- <a href="javascript:void(0)" title="Delete" id="swal-demo5"><i class="fa fa-trash"></i></a> --}}
                 <a href="{{ asset($file) }}" title="View" target="_blank"><i class="fa fa-search-plus"></i></a>

               </div>
             </div>
           </div>
         </div>
         @endforeach
         @endif
         </div>
         <!-- attachment row end -->
       </div>
     </div>

     <!-- row end -->
    @foreach($emaillog->emaillogcomments as $comm)
     <div class="row msg_row">
      @if($comm->user_id==Auth::id() && $loop->last)
      <button class="btn btn-default pull-right" onclick="updateStatus({{ $comm->id }})"><i class="fa fa-trash fa-2x text-danger"></i></button>
      <form action="{{ route('decemail-comments.update',['id'=>$comm->id]) }}" method="post" id="form-status{{ $comm->id }}" style="display: none;">
      @csrf
      @method('put')
      <input type="hidden" name="id" value="{{ $comm->id }}">
      <input type="hidden" name="status" value="{{ $comm->status }}">
      </form>
      @endif
       <div class="col-sm-12">
        <div class="user_mg_row">
          <div class="user_mg_col">
            <div class="name_circle">{{ $comm->user->first_name[0] }}</div>
          </div>
          <div class="user_mg_col">
            <h5>{{ $comm->user->first_name }} {{ $comm->user->last_name }} <small>{{ $comm->created_at->format('d-m-Y h:i:s a') }}</small>
            </h5>
            <p>
              {{ $comm->content }}
            </p>

          </div>
        </div>

        <!-- attachment row -->
        <div class="row">
          @if(!empty(json_decode($comm->files)))
          @foreach(json_decode($comm->files) as $file)
         <div class="col-sm-2">
           <div class="file-icon-c2 text-center">  

             <div class="boxdus">
               <i class="fa fa-file-text-o"></i>
               @php
                 $fileArr = explode('/', $file);
               @endphp
               <p>{{ $fileArr[count($fileArr)-1] }} <br><span></span></p>
             </div>
             <div class="row rowcmc">
               <div class="col-sm-12 footerlist-attach">
                 <a href="{{ asset($file) }}" title="Download" download="">
                   <i class="fa fa-cloud-download"></i></a>
                   {{-- <a href="javascript:void(0)" title="Delete" id="swal-demo5"><i class="fa fa-trash"></i></a> --}}
                   <a href="{{ asset($file) }}" title="View" target="_blank"><i class="fa fa-search-plus"></i></a>

                 </div>
               </div>
             </div>
           </div>
           @endforeach
           @endif
           </div>
           <!-- attachment row end -->
         </div>
       </div>
       @endforeach

       <!-- row end -->



       <div class="panel-body" style="    box-shadow: 0 0 10px #ccc;">
         <form method="post" action="{{ route('decemail-comments.store') }}" class="form-horizontal" enctype="multipart/form-data">
         @csrf
         <input type="hidden" name="dec_email_log_id" value="{{ $emaillog->id }}">
         <input type="hidden" name="lead_id" value="{{ $emaillog->lead_id }}">
          <div class="form-group">
            <div class="col-sm-12">
              <label class="control-label">
                Comments
              </label>
              <textarea rows="3" class="form-control" placeholder="Type.." name="content" required=""></textarea>
            </div>
          </div>
          <div class="form-group">
           <div class="col-sm-12">
            <label class="control-label">
             Attachments
           </label>
           <input type="file" name="file[]" class="form-control filestyle" multiple="">
         </div>
       </div>


       <div class="form-group">
        <div class="col-sm-12">
          <a href="{{ route('leads.decision',['id'=>base64_encode($emaillog->lead_id)]) }}" class="btn btn-warning ">Back</a>
          <div class="pull-right">
            <button class="btn btn-info " type="submit">Reply</button>
          </div>  
        </div>
      </div>

    </form>
  </div>

</div>
</div>

</div>
@endsection

@section('custom_js')
  <!-- =============== PAGE VENDOR SCRIPTS ===============-->
   <script type="text/javascript" src="{{ asset('js/bootstrap-filestyle.js') }}"></script>
   <!-- Status-->
   @component('components.status-delete-js')
   @slot('form')
       form-status
   @endslot
   @slot('title')
       updateStatus
   @endslot
   @endcomponent
@endsection