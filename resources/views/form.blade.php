@extends('layouts.master')

@section('content')
<div class="content-wrapper">
  <div class="content-heading">
     <span><em class="fa fa-file-text-o"></em>  Form list</span> 
     <div class="pull-right"><a href="{{ route('forms.create') }}" class="btn btn-info btn-sm"><em class="fa fa-file-text-o"></em> Create form </a></div>
  </div>

  <div class="panel panel-default">
     <div class="panel-body">
        <div class="list-group">
    @if (count($categories) === 0)
        No data found!
    @endif
    @foreach ($categories as $row)
     <a href="javascript:void(0)" class="list-group-item">
        <table class="wd-wide">
         

           <tbody>
              <tr>
                 <td class="ph">
                    <div class="ph">
                     <h4> {{ $row->name }}</h4>

                      <p><small> {{ $row->created_at->format('d-m-Y h:i:s a') }} </small> </p>

                    </div>
                 </td>

                  <td class="wd-xs hidden-xs hidden-sm">
                   <div class="ph">
                     <a href="{{ route('forms.view', ['form'=>base64_encode($row->id)]) }}" class="btn btn-sm btn-purple">
                       View form
                     </a>
                   </div>
                 </td>
                
                {{--  <td class="wd-xs hidden-xs hidden-sm">
                   <div class="ph">
                       <a href="javascript:void(0)" class="btn btn-sm btn-purple">
                         Edit form
                       </a>
                    </div>
                 </td>
               
                 <td class="wd-xs hidden-xs hidden-sm">
                    <div class="ph">
                       <a href="javascript:void(0)" class="btn btn-sm btn-green">
                        Copy form
                       </a>
                    </div>
                 </td>
                   <td class="wd-xs hidden-xs hidden-sm">
                    <div class="ph">
                       <a href="javascript:void(0)" class="btn btn-sm btn-danger" id="swal-demo4">
                         Delete form
                       </a>
                    </div>
                 </td> --}}
                 
              </tr>

           </tbody>
        </table>
     </a>
     @endforeach
  </div>
     </div>
  </div>
</div>
@endsection

@section('custom_js')

@endsection