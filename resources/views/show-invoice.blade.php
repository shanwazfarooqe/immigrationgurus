@extends('layouts.master')

@section('content')
<div class="content-wrapper">

 <div class="content-heading">
  <span><em class="fa fa-file-text-o"></em> Invoice </span> 
  <div class="pull-right">
    <a href="{{ route('invoices.index',['lead'=>base64_encode($invoice->lead_id)]) }}" class="btn btn-info btn-lg">Back to invoice</a>
    <button class="btn btn-info btn-lg" data-toggle="modal" data-target="#recdr_payment"><em class="fa fa-file-text-o"></em> Record a Payment</button>
  </div>
</div>
<div style="width:80%;margin-left:10%;border:solid #CCC .5px;min-height:500px;overflow:hidden;background-color:#FFF;box-shadow:1px 1px 50px #D9D9D9;" class="main">
 <div style="background-color:#fff;overflow:overlay;padding-top:25px;padding-bottom:25px;">
   <div style="width:94%;margin-left:3%;margin-right:3%;">
     <div style="float:left;margin-top:5px;"><h2 style="color:#fff;font-size:25px;">
       <img src="
       @if(Auth::user()->logo || Auth::user()->parent['logo'])
         @if(file_exists(Auth::user()->logo))
           {{ asset(Auth::user()->logo) }}
         @elseif(file_exists(Auth::user()->parent->logo))
           {{ asset(Auth::user()->parent->logo) }}
         @endif
       @else
         {{ asset('img/logo.png') }}
       @endif
       " alt="logo" style="max-height: 100px;width: auto;" /></div>
       <div style="float:right;"><h2 style="color: #71bd05;float: left;border-bottom: solid #fff 2px;line-height: 11px;    margin-top: 31px;">INVOICE&nbsp;&nbsp;&nbsp;&nbsp;</h2>
         <p style="color: #71bd05;"> Invoice No : {{ $invoice->invoice_no }}<br /></p>
       </div>
     </div>
   </div>
   <div style="clear:both;"></div>
   <hr>
   <div style="width:94%;margin-left:3%;margin-right:3%;margin-top:20px;">
     <div  style="float:left;">
      <p>From ,</p>
      <p style="font-size:14px;color:#666;line-height:25px;">
       {{ $company->company_name }}<br>
       {{ nl2br($company->address) }}
     </p>
   </div>
   <div style="float:right;text-align:right;">
     <p>To ,</p>
     <p style="font-size:14px;color:#666;line-height:25px;">

       {{ $lead->first_name }} {{ $lead->last_name }}<br>
       {{ nl2br($lead->address) }} <br>
       {{ $lead->email }}
       
     </p>
   </div>
 </div>
 <div style="clear: both;"></div>
 <hr>


 <div style="width:94%;margin-left:3%;margin-right:3%;margin-top:20px;">
   <div style="float:right;text-align:right;">
     <p style="font-size:14px;color:#666;line-height:25px;">
      Date of Invoice : {{ $invoice->invoice_date->format('d/m/Y') }}<br />
      Invoice due : {{ $invoice->payment_duedate->format('d/m/Y') }} <br>
      Amount Due  : 1,430.00$<br> 

    </p>
  </div>
</div>
<div style="clear: both;"></div>
<div style="clear: both;"></div>
<table cellspacing="10" border="0" style="width:94%;margin-left:3%;margin-right:3%;margin-top:10px;margin-bottom: 20px;">
 <tr>

   <th class="ht" style="width:58%;background-color:#71bd05;color:#FFF;line-height:30px; font-weight: 300; text-align: left; padding-left: 3px">Service 
   </th>
   <th class="ht" style="width:14%;background-color:#032e52;color:#FFF;line-height:30px; font-weight: 300; text-align: left; padding-left: 3px">Hrs</th>
   <th class="ht" style="width:14%;background-color:#71bd05;color:#FFF;line-height:30px; font-weight: 300; text-align: left; padding-left: 3px">Rate</th>
   <th class="ht" style="width:14%;background-color:#71bd05;color:#FFF;line-height:30px; font-weight: 300; text-align: left; padding-left: 3px">Amount</th>
 </tr>
@php
  $subtotal = array();
  $payment_total = array();
@endphp
@foreach($invoice->services as $row)
@php
  $subtotal[] = $row->hrs * $row->rate;
@endphp
 <tr>
   <td style="color:#666;line-height:20px;font-size:14px;border-bottom:solid #71bd05 2px;padding-bottom:10px;padding-left: 3px;">{{ $row->name }}</td>
   <td style="color:#666;line-height:20px;font-size:14px;border-bottom:solid #71bd05 2px;padding-bottom:10px;padding-left: 3px;">{{ $row->hrs }}</td>
   <td style="color:#666;line-height:20px;font-size:14px;border-bottom:solid #032e52 2px;padding-bottom:10px;padding-left: 3px;"> $ &nbsp;  {{ $row->rate }} </td>
   <td style="color:#666;line-height:20px;font-size:14px;border-bottom:solid #032e52 2px;padding-bottom:10px;padding-left: 3px;"> $ &nbsp;  {{ $row->hrs * $row->rate }} </td>
 </tr>
 @endforeach

 <tr>
   <td colspan="3" style="color:#032e52;line-height:20px;font-size:14px;padding-left: 3px; padding-top: 20px;" valign="middle" align="right">
   Total: </td>
   <td  style="color:#032e52;line-height:20px;font-size:14px;padding-bottom:10px;padding-left: 3px; padding-top: 20px;"><strong> $ &nbsp; {{ array_sum($subtotal) }}</strong></td>
 </tr>
@foreach($invoice->payment_records as $row)
@php
  $payment_total[] = $row->amount
@endphp
 <tr>
   <td colspan="3" style="color:#032e52;line-height:20px;font-size:14px;padding-left: 3px;" valign="middle" align="right">
   Payment on {{ $row->payment_date->format('F d\, Y') }} using {{ $row->method }}: </td>
   <td  style="color:#032e52;line-height:20px;font-size:14px;border-bottom:solid #032e52 2px;padding-bottom:10px;padding-left: 3px;"><strong> $ &nbsp; {{ $row->amount }}</strong></td>
 </tr>
@endforeach
 <tr>
   <td colspan="3" style="color:#032e52;line-height:20px;font-size:14px;padding-left: 3px;" valign="middle" align="right">
   Amount Due:  </td>
   <td  style="color:#032e52;line-height:20px;font-size:14px;border-bottom:solid #032e52 2px;padding-bottom:10px;padding-left: 3px;"><strong> $ &nbsp;  {{ (array_sum($subtotal) - array_sum($payment_total)) }}</strong></td>
 </tr>


</table>

<div style="clear: both;"></div>
<div style="width:100%;min-height:120px;background-color:#71bd05;overflow:hidden;" class="ftr">
 <div style="width:100%;margin-left:auto;margin-right:auto;margin-top:30px;">
   <div  style="padding-bottom: 20px;text-align: center; color: #FFF">
     <p>
       BANK DETAILS <br>
       Direct Deposit: National Australia Bank<br>
       BSB: 082-837<br>
       A/C No.: 55-197-6958<br>
       <br>

     </p>

   </div>

 </div>

</div>
</div>

</div>
@endsection

@section('custom_js')
  <!-- =============== PAGE VENDOR SCRIPTS ===============-->
  <script src="{{ asset('js/jquery.hotkeys.js') }}"></script>
  <!-- MOMENT JS-->
  <script src="{{ asset('js/moment-with-locales.min.js') }}"></script>
   <!-- DATETIMEPICKER-->
  <script type="text/javascript" src="{{ asset('js/bootstrap-datetimepicker.min.js') }}">
  </script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#datetimepicker1').datetimepicker({
          format: "DD/MM/YYYY"         
      });
    });
  </script>
  <div class="modal fade" id="recdr_payment">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Record a Payment for this Invoice</h4>
        </div>
        <form method="post" action="{{ route('invoices.record') }}" class="form-horizontal">
        @csrf
        <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
        <div class="modal-body">
          <p>Record a payment you’ve already received, such as cash, cheque, or bank payment.</p>
          <div class="form-group">
             <div class="col-sm-12">
                 <label class="control-label">
                   Payment date
                 </label>
                <div  class="input-group date" id="datetimepicker1">
                 <input type="text" class="form-control"  value="{{ date('d/m/Y') }}" name="payment_date" required="">
                 <span class="input-group-addon">
                    <span class="fa fa-calendar"></span>
                 </span>
              </div>
              </div>
              </div>
            <div class="form-group">
              <div class="col-sm-6">
                 <label class="control-label">
                  Amount
                 </label>
                 <input type="text" name="amount" class="form-control" placeholder="Last name" required="">
              </div>
             <div class="col-sm-6">
                 <label class="control-label">
                  Payment method
                 </label>
                 <select class="form-control select2-4" name="method" required="">
                <option>method 1</option>
                <option>method 2</option>
                <option>method 3</option>
                <option>method 4</option>
              </select>
              </div>
           </div>
            <div class="form-group">
             <div class="col-sm-12">
                 <label class="control-label">
                  Memo / notes
                 </label>
                 <textarea name="description" cols="" rows="4" class="form-control" placeholder="Type.." required=""></textarea>
              </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-info">Submit</button>
        </div>
        </form>
      </div>
    </div>
  </div>
@endsection