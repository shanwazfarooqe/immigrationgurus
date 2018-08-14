@extends('auth.master')
@section('content')
<div class="block-center mt-xl wd-xl login" id="card">
 <!-- START panel-->
 <div class="panel panel-flat front signin_form">
  <div class="panel-heading text-center">
   <div class="login-icon">
     <img src="{{ asset('img/User-Circle.png') }}" alt="" width="100">
   </div>
   <h2>User Login</h2>
 </div>
 <div class="panel-body">
  <form action="{{ route('login') }}" method="post" class="mb-lg">
   @csrf
   @component('components.warning-alert')
   @endcomponent

   <div class="form-group has-feedback">
    <span class="icon-user form-control-feedback text-muted"></span>
    <input name="email" type="text" placeholder="Email" class="form-control">
    
  </div>
  <div class="form-group has-feedback">
   <span class="icon-lock form-control-feedback text-muted"></span>
   <input name="password" type="password" placeholder="Password" class="form-control">
   
 </div>
 <div class="form-group">
  <div class="form-check checkbox c-checkbox">
    <label class="form-check-label">
      <input type="checkbox" class="form-check-input" name="remember" value="Value" {{ old('remember') ? 'checked' : '' }}>  <span class="fa fa-check"></span>{{ __('Remember Me') }}
    </label>
  </div>
</div>
<div class="clearfix">
 
 <div class="pull-right" style="color:#FFFFFF"><a href="{{ route('password.request') }}" class="text-muted">{{ __('Forgot Your Password?') }}</a>
 </div>
</div>
<button type="submit" class="btn btn-block btn-ig mt-lg">LOG IN</button>
</form>
</div>
</div>
<!-- END panel-->
</div>
@endsection

@section('custom_js')

@endsection