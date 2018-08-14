@extends('layouts.master')

@section('content')
<div class="content-wrapper">

  <div class="content-heading">
   <span><em classs="fa fa-file-text-o"></em> Create invoice </span> 

 </div>

 <div class="panel panel-default">
   <div class="panel-body">
    <form method="post" action="{{ route('invoices.store',['lead'=>base64_encode($lead->id)]) }}" class="form-horizontal">
    @csrf
      <input type="hidden" name="lead_id" value="{{ $lead->id }}">
      <div class="invoice_container">
        <div class="row">
          <div class="col-sm-8">
            <div class="customer_detail_box">
             <strong>Bill to</strong> <br>
             {{ $lead->first_name }} {{ $lead->last_name }} <br>
             {{ nl2br($lead->address) }}
           </div>
         </div>
         <div class="col-sm-4">
          <div class="form-group">
            <div class="col-sm-5">
             Invoice Number
           </div>
           <div class="col-sm-7">
             <input type="text" name="invoice_no" class="form-control" value="{{ $lead->id }}IVI{{ strtoupper(str_random(4)) }}{{ time() }}" required="">
           </div>
         </div>
         <div class="form-group">
          <div class="col-sm-5">
            P.O./S.O. Number
          </div>
          <div class="col-sm-7">
           <input type="text" name="po_so_no" class="form-control" required="">
         </div>
       </div>
       <div class="form-group">
        <div class="col-sm-5">
         Invoice Date
       </div>
       <div class="col-sm-7">
         <div class="input-group date " id="datetimepicker1">
           <input type="text" class="form-control" value="{{ date('d/m/Y') }}" required="" name="invoice_date">
           <span class="input-group-addon">
            <span class="fa fa-calendar"></span>
          </span>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-5">
       Payment Due
     </div>
     <div class="col-sm-7">
       <div class="input-group date " id="datetimepicker2">
         <input type="text" class="form-control" placeholder="" required="" name="payment_duedate">
         <span class="input-group-addon">
          <span class="fa fa-calendar"></span>
        </span>
      </div>
    </div>
  </div>
</div>
</div>
<!-- header end ===============================-->
<div class="row">
  <table class="table table-striped table-hover table_invoice">
    <thead class="invoice head">
      <tr>
        <th>Service</th>
        <th>Hrs</th>
        <th>Rate</th>
        <th>Amount</th>
      </tr>
    </thead>
    <tbody class="loopo_row">
      <tr><td class="td_invoice_item"><input type="text" class="form-control input-invoice" placeholder="Enter service" name="name[]" required><input type="text" class="form-control input-invoice" placeholder="Service description" name="description[]" required></td><td><input type="number" class="form-control" onkeyup="calc1(this)" placeholder="Type.." name="hrs[]" step="any" min="0" required></td><td><input type="number" class="form-control" onkeyup="calc2(this)" placeholder="Type.." name="rate[]" step="any" min="0" required></td><td class="dispratecontainer"><span>$ </span><span class="disprate"> </span></td></tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="4">
          <a href="javascript:void(0)" id="add_roow">
            <div class="text-center add_more_div">
              <h4>Add an item <i class="fa fa-plus-circle"></i></h4>
            </div>
          </a>
        </td>
      </tr>
      <tr>
       <td colspan="3" align="right"><h4><strong>Subtotal</strong> </h4></td>
       <td><h4><span>$ </span><span class="subtot"> </span></h4> </td>
     </tr>
     <tr>
       <td colspan="3" align="right"><h4><strong>Total</strong></h4> </td>
       <td><h4><span>$ </span><span class="subtot"> </span></h4></td>
     </tr>
   </tfoot>
 </table>
</div>
<!-- table end ===============================-->
<hr>
<div class="form-group">
  <div class="col-sm-12">
    <label class="control-label">Notes</label>
    <textarea class="form-control" rows="5" style="border:none;" name="content">
      BANK DETAILS 
      Direct Deposit: National Australia Bank
      BSB: 082-837
      A/C No.: 55-197-6958
    </textarea>
  </div>
</div>
<div class="form-group">
 <div class="col-sm-12">
   <button class="btn btn-sm btn-success btn-lg pull-right" type="submit">Create invoice</button>
 </div>
</div>
</div>
</form>
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
      $('#datetimepicker2').datetimepicker({
          format: "DD/MM/YYYY"         
      });
      $("#add_roow").click(function(event) {
       var html = $('.loop_data').html();
       $('.loopo_row').append('<tr><td class="td_invoice_item"><input type="text" class="form-control input-invoice" placeholder="Enter service" name="name[]" required><input type="text" class="form-control input-invoice" placeholder="Service description" name="description[]" required></td><td><input type="number" class="form-control" onkeyup="calc1(this)" placeholder="Type.." name="hrs[]" step="any" min="0" required></td><td><input type="number" class="form-control" onkeyup="calc2(this)" placeholder="Type.." name="rate[]" step="any" min="0" required></td><td class="dispratecontainer"><span>$ </span><span class="disprate"> </span><i class="fa fa-trash text-danger fa-2x fa_deletec"></i></td></tr>');

       $('.fa_deletec').click(function(event) {
         $(this).parent().parent().remove();
         getSubTotal();
       });
      });
    });

    function calc1(ele) {
      var hrs = $(ele).val();
      var rate = $(ele).parent().next().children('[name="rate[]"]').val();
      $(ele).parent().siblings('td.dispratecontainer').children('span.disprate').html(hrs * rate);
      getSubTotal();
    }

    function calc2(ele) {
      var rate = $(ele).val();
      var hrs = $(ele).parent().prev().children('[name="hrs[]"]').val();
      $(ele).parent().siblings('td.dispratecontainer').children('span.disprate').html(hrs * rate);
      getSubTotal();
    }

    function getSubTotal()
    {
      var tot = 0;
      $('.disprate').each(function(index, el) {
        tot += parseFloat($(el).html());
      });
      $('.subtot').html(tot);
    }

    $(document).ready(function() {
      getSubTotal();
    });

  </script>
@endsection