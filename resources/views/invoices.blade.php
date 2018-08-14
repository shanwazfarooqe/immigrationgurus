@extends('layouts.master')

@section('content')
<div class="content-wrapper">

  <div class="content-heading">
   <span><em class="fa fa-file-text-o"></em> Invoice </span> 
   <div class="pull-right"><a href="{{ route('invoices.create',['lead'=>base64_encode($lead)]) }}" class="btn btn-info btn-sm"><em class="fa fa-file-text-o"></em> Create invoice </a></div>
 </div>

 <div class="panel panel-default">
   <div class="panel-body">
    <div class="list-group">
  @foreach($invoices as $row)
     <a href="{{ route('invoices.show',['lead'=>base64_encode($row->lead_id),'id'=>base64_encode($row->id)]) }}" class="list-group-item">
      <table class="wd-wide">
       <tbody>
        <tr>
         <td class="wd-xs">
          <div class="ph">
           <img src="{{ asset('img/invoice_icon.png') }}" alt="" class="media-box-object img-responsive img-rounded thumb64">
         </div>
       </td>
       <td>
        <div class="ph">
         <h4 class="media-box-heading">{{ $row->invoice_no }}</h4>
         <small class="text-muted"></small>
       </div>
     </td>
     <td class="wd-sm hidden-xs hidden-sm">
      <div class="ph">
       <p class="m0">Amount</p>
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
       <p class="text-muted">{{ (array_sum($subtot) - array_sum($paytot)) }}</p>
     </div>
   </td>

   <td class="wd-xs hidden-xs hidden-sm">
    <div class="ph">
     <p class="m0 text-muted">
      @if( (array_sum($subtot) - array_sum($paytot) <= 0) )
       <span class="label label-cm pull-right">Paid <em class="fa fa-fw fa-check mr"></em></span>
      @else
        <span class="label label-danger pull-right">Not paid <em class="fa fa-fw fa-check mr"></em></span>
      @endif
     </p>
     </div>
   </td>

 </tr>
</tbody>
</table>
</a>
@endforeach
@if (count($invoices) === 0)
    No data found!
@endif
</div>
<hr>

</div>
</div>

</div>
@endsection

@section('custom_js')

@endsection