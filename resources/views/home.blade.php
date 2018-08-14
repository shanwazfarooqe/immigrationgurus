@extends('layouts.master')

@section('content')
<div class="content-wrapper">
 <div class="content-heading ">
   <div class="row">
       <div class="col-sm-8">
         <span>  <em class="fa fa-dashboard"></em> Dashboard</span>
     </div> 
     <div class="col-sm-4">
         <div class="input-group">
             <input type="text" name="" class="serch-cust" placeholder="Search customer">
             <a href="user-self-view.html" class="input-group-addon dash-link">Go</a>
         </div>
     </div>  
 </div>
</div>

<div class="panel panel-default">
   <div class="panel-heading">

     <div class="box-innside box-body">
        <div id="counter">
           <div class="row">
            <div  class="col-lg-3 col-md-6 col-sm-6">
             <div  class="card card-stats">
                 <div  class="card-header panel-color1" >
                  <img src="img/leads-icon.png" alt="image" class="img-responsive">
              </div>
              <div  class="card-content">
                 <p  class="category">New Leads</p>
                 <h3 class="title counter-value" data-count="130">0</h3>

             </div>
             <div  class="card-footer">
                 <div  class="stats">
                  <i class="fa fa-calendar"></i> Today (02/02/2017)
              </div>
          </div>
      </div>
  </div>
  <div  class="col-lg-3 col-md-6 col-sm-6">
     <div  class="card card-stats">
         <div  class="card-header panel-color2" >
             <img src="img/application.png" alt="image" class="img-responsive">
         </div>
         <div  class="card-content">
             <p  class="category">Applications</p>
             <h3 class="title counter-value" data-count="10">0</h3>
         </div>
         <div  class="card-footer">
             <div  class="stats">
              <i class="fa fa-calendar"></i> Today (02/02/2017)
          </div>
      </div>
  </div>
</div>
<div  class="col-lg-3 col-md-6 col-sm-6">
 <div  class="card card-stats">
     <div  class="card-header panel-color3" >

      <i class="fa fa-calendar-minus-o"></i>
  </div>
  <div  class="card-content">
     <p  class="category"> Lorem Ipsum</p>
     <h3 class="title counter-value" data-count="5">0</h3>
 </div>
 <div  class="card-footer">
     <div  class="stats">
      <i class="fa fa-calendar"></i> Today (02/02/2017)
  </div>
</div>
</div>
</div>
<div  class="col-lg-3 col-md-6 col-sm-6">
 <div  class="card card-stats">
     <div  class="card-header panel-color4" >
      <i class="fa fa-calendar-minus-o"></i>
  </div>
  <div  class="card-content">
     <p  class="category">Lorem Ipsum</p>
     <h3 class="title counter-value" data-count="115">0</h3>
 </div>
 <div  class="card-footer">
     <div  class="stats">
      <i class="fa fa-calendar"></i> Today ((02/02/2017))
  </div>
</div>
</div>
</div>

</div>
</div>

</div>
</div>
</div>
<div class="row">
 <div class="col-sm-8" style="padding-right: 0px;">
     <div class="panel panel-default">
      <div class="panel-body">
         <div class="calendar-app">
          <div id="calendar"></div>
      </div>
  </div>
</div>
</div>
<div class="col-sm-4" style="padding-left: 0px">
 <div class="panel panel-default">
   <div class="panel-heading">
       <div class="panel-title">
         <h4>Wednesday <small class="pull-right">06 june 2018</small></h4>

     </div>
 </div>
 <div class="panel-body">
  <div  data-height="521" data-scrollable="" class="list-group " >
   <!-- START list group item-->
   <a href="#" class="list-group-item list-group-item_S">
    <div class="media-box">
     <div class="pull-left">
         <span class="circle circle-bg1  text-left"></span>
     </div>
     <div class="media-box-body clearfix">
      <div class="media-box-heading" data-toggle="tooltip" title="Lorem Ipsum is simply dummy">
         <p>Lorem Ipsum is simply dummy</p> </div>
         <p class="mb-sm">
           <small>2am - 4am </small>
       </p>
   </div>
</div>
</a>
<!-- END list group item-->
<!-- START list group item-->
<a href="#" class="list-group-item">
    <div class="media-box">
     <div class="pull-left">
         <span class="circle circle-bg2  text-left"></span>
     </div>
     <div class="media-box-body clearfix">
      <div class="media-box-heading" data-toggle="tooltip" title="Lorem Ipsum is simply dummy">
         <p>Lorem Ipsum is simply dummy</p> </div>
         <p class="mb-sm">
           <small>4am - 6am </small>
       </p>
   </div>
</div>
</a>
<!-- END list group item-->
<!-- START list group item-->
<a href="#" class="list-group-item">
    <div class="media-box">
     <div class="pull-left">
         <span class="circle circle-bg3  text-left"></span>
     </div>
     <div class="media-box-body clearfix">
      <div class="media-box-heading" data-toggle="tooltip" title="Lorem Ipsum is simply dummy">
         <p>Lorem Ipsum is simply dummy</p> </div>
         <p class="mb-sm">
           <small>6am - 8am </small>
       </p>
   </div>
</div>
</a>
<!-- END list group item-->
<!-- START list group item-->
<a href="#" class="list-group-item">
    <div class="media-box">
     <div class="pull-left">
         <span class="circle circle-bg4  text-left"></span>
     </div>
     <div class="media-box-body clearfix">
      <div class="media-box-heading" data-toggle="tooltip" title="Lorem Ipsum is simply dummy">
         <p>Lorem Ipsum is simply dummy</p> </div>
         <p class="mb-sm">
           <small>8am - 10am </small>
       </p>
   </div>
</div>
</a>
<!-- END list group item-->

<!-- START list group item-->
<a href="#" class="list-group-item">
    <div class="media-box">
     <div class="pull-left">
         <span class="circle circle-bg1  text-left"></span>
     </div>
     <div class="media-box-body clearfix">
      <div class="media-box-heading" data-toggle="tooltip" title="Lorem Ipsum is simply dummy">
         <p>Lorem Ipsum is simply dummy</p> </div>
         <p class="mb-sm">
           <small>8am - 10am </small>
       </p>
   </div>
</div>
</a>
<!-- END list group item-->

<!-- START list group item-->
<a href="#" class="list-group-item">
    <div class="media-box">
     <div class="pull-left">
         <span class="circle circle-bg2  text-left"></span>
     </div>
     <div class="media-box-body clearfix">
      <div class="media-box-heading" data-toggle="tooltip" title="Lorem Ipsum is simply dummy">
         <p>Lorem Ipsum is simply dummy</p> </div>
         <p class="mb-sm">
           <small>8am - 10am </small>
       </p>
   </div>
</div>
</a>
<!-- END list group item-->
<!-- START list group item-->
<a href="#" class="list-group-item">
    <div class="media-box">
     <div class="pull-left">
         <span class="circle circle-bg4  text-left"></span>
     </div>
     <div class="media-box-body clearfix">
      <div class="media-box-heading" data-toggle="tooltip" title="Lorem Ipsum is simply dummy">
         <p>Lorem Ipsum is simply dummy</p> </div>
         <p class="mb-sm">
           <small>8am - 10am </small>
       </p>
   </div>
</div>
</a>
<!-- END list group item-->

<!-- START list group item-->
<a href="#" class="list-group-item">
    <div class="media-box">
     <div class="pull-left">
         <span class="circle circle-bg3  text-left"></span>
     </div>
     <div class="media-box-body clearfix">
      <div class="media-box-heading" data-toggle="tooltip" title="Lorem Ipsum is simply dummy">
         <p>Lorem Ipsum is simply dummy</p> </div>
         <p class="mb-sm">
           <small>8am - 10am </small>
       </p>
   </div>
</div>
</a>
<!-- END list group item-->
</div>
</div>
</div>
</div>
</div>
</div>
@endsection

@section('custom_css')
<!-- FULLCALENDAR-->
<link rel="stylesheet" href="{{ asset('css/fullcalendar.css') }}">
@endsection

@section('custom_js')
  <!-- =============== PAGE VENDOR SCRIPTS ===============-->
  <script src="{{ asset('js/jquery.slimscroll.min.js') }}"></script>
  <!-- MOMENT JS-->
  <script src="{{ asset('js/moment-with-locales.min.js') }}"></script>
  <!-- FULLCALENDAR-->
  <script src="{{ asset('js/fullcalendar.min.js') }}"></script>
  <script src="{{ asset('js/gcal.js') }}"></script>

  <!-- number count -->
   <script type="text/javascript">
    var a = 0;
    $( document ).ready(function() {

      var oTop = $('#counter').offset().top - window.innerHeight;
      if (a == 0 && $(window).scrollTop() > oTop) {
        $('.counter-value').each(function() {
          var $this = $(this),
          countTo = $this.attr('data-count');
          $({
            countNum: $this.text()
          }).animate({
            countNum: countTo
          },

          {

            duration: 2000,
            easing: 'swing',
            step: function() {
              $this.text(Math.floor(this.countNum));
            },
            complete: function() {
              $this.text(this.countNum);
                    //alert('finished');
                  }

                });
        });
        a = 1;
      }

    });
   
  </script>
@endsection
