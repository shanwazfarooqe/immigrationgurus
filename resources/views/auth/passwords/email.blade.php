@extends('auth.master')
@section('content')
<div class="block-center mt-xl wd-xl login" id="card">
  
 <div class="panel panel-flat back signup_form">
  <div class="panel-heading text-center">
   <div class="login-icon">
     <img src="{{ asset('img/lock-Circle.png') }}" alt="" width="100">
   </div>
   <h2>Forgot Password</h2>
   <p class="text-center">Please enter your registered email address and click on submit button</p>
 </div>

 <form action="{{ route('password.email') }}" method="post" class="mb-lg">
  @csrf
  @component('components.warning-alert')
  @endcomponent
  <div class="panel-body">
    <div class="form-group has-feedback">
     <span class="fa fa-envelope-o form-control-feedback text-muted"></span>
     <input name="email" type="text" placeholder="Email" class="form-control">
     
   </div>
   <div class="form-group ">
     <div class="col-sm-12"> 
      <button class="btn btn-ig btn-block" type="submit">Submit  </button>
    </div>
  </div>
</div>
<div class="clearfix">
  <div class="form-group ">
   <div class="col-sm-12"> 
    <a href="{{ route('login') }}"><i class="fa fa-arrow-circle-left signup text-default" title="Back To Login"></i></a>
  </div>
</div>
</div>
</form>

</div>
</div>
@endsection